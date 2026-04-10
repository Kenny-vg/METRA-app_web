<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Helpers\ApiResponse;
use App\Services\CloudinaryService;

class RenovarSuscripcionController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }
    /**
     * El gerente solicita renovación de su suscripción.
     *
     * LÓGICA CORREGIDA (sin duplicados):
     * - Busca la suscripción vigente o más reciente de la cafetería.
     * - Guarda un snapshot del estado anterior en renovaciones_historial.
     * - Actualiza el registro principal con el nuevo comprobante, plan y fechas.
     * - Marca en_revision=true y estado_pago='pendiente' para que el Superadmin lo vea.
     * - Si no existe ninguna suscripción previa, crea una nueva (primer registro).
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // 1. Intentar resolver el token si no viene en el request
        if (!$user) {
            $user = auth('sanctum')->user();
        }

        // 2. Fallback: buscar usuario por email (flujo desde la pantalla de login cuando la sub está vencida)
        if (!$user) {
            $dataEmail = $request->validate([
                'email' => 'nullable|email|exists:users,email'
            ], [
                'email.exists' => 'No se encontró una cuenta con este correo electrónico.'
            ]);

            if (!empty($dataEmail['email'])) {
                $user = \App\Models\User::where('email', $dataEmail['email'])->first();
            }
        }

        if (!$user || !in_array($user->role, ['gerente'])) {
            return ApiResponse::error('Usuario no válido para renovación.', 403);
        }

        $cafeteria = $user->cafeteria;

        if (!$cafeteria) {
            return ApiResponse::error('No tienes una cafetería asociada.', 404);
        }

        $data = $request->validate([
            'plan_id'     => 'required|exists:planes,id',
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $plan = Plan::where('id', $data['plan_id'])->where('estado', true)->first();
        if (!$plan) {
            return ApiResponse::error('El plan seleccionado no está disponible.', 422);
        }

        // Verificar si ya hay una solicitud en revisión para evitar spam
        $yaEnRevision = Suscripcion::where('cafe_id', $cafeteria->id)
            ->where('en_revision', true)
            ->where('estado_pago', 'pendiente')
            ->exists();

        if ($yaEnRevision) {
            return ApiResponse::error('Ya tienes una renovación pendiente de aprobación. Espera a que el Superadmin la revise.', 422);
        }

        // Buscar la suscripción principal más reciente de esta cafetería
        $suscripcionExistente = Suscripcion::where('cafe_id', $cafeteria->id)
            ->latest('id')
            ->first();

        // Guardar el nuevo comprobante en Cloudinary (privado/autenticado)
        try {
            $result = $this->cloudinary->uploadPrivate($request->file('comprobante'), 'metra/comprobantes');
        } catch (\Throwable $e) {
            \Log::error("Error Cloudinary upload renovación: " . $e->getMessage());
            return ApiResponse::error('Error al subir el comprobante a Cloudinary', 500);
        }

        // Calcular las nuevas fechas esperadas para la renovación (como propuesta inicial)
        $suscripcionActiva = Suscripcion::where('cafe_id', $cafeteria->id)
            ->where('estado_pago', 'pagado')
            ->where('fecha_fin', '>', now())
            ->latest('fecha_fin')
            ->first();

        if ($suscripcionActiva) {
            // Si el plan solicitado es diferente al actual (Ej. Upgrade), empezar hoy mismo.
            if ($suscripcionActiva->plan_id != $plan->id) {
                $inicio = now()->startOfDay();
            } else {
                // Si es el mismo plan (Renovación normal), agregarlo al final del periodo actual.
                $inicio = \Carbon\Carbon::parse($suscripcionActiva->fecha_fin)->startOfDay()->addDay();
            }
        } else {
            $inicio = now()->startOfDay();
        }
        $fin = $inicio->copy()->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

        // ─── Siempre crear una nueva solicitud en el historial 1:N ───
        $suscripcion = Suscripcion::create([
            'cafe_id'                => $cafeteria->id,
            'plan_id'                => $plan->id,
            'plan_solicitado_id'     => null,
            'user_id'                => $user->id,
            'fecha_inicio'           => $inicio,
            'fecha_fin'              => $fin,
            'monto'                  => $plan->precio,
            'comprobante_public_id'  => $result['public_id'],
            'comprobante_url'        => null,
            'estado_pago'            => 'pendiente',
            'en_revision'            => true,
        ]);

        // ─── Si la cuenta fue rechazada previamente o está inactiva, restaurar estados para re-revisión ───
        if ($user->estatus_registro === 'rechazado' || !$user->estado) {
            $user->update([
                'estado'           => true, 
                'estatus_registro' => 'pendiente',
            ]);

            // Si la cafetería estaba suspendida (por rechazo inicial), marcarla en revisión
            if ($cafeteria->estado === 'suspendida') {
                $cafeteria->update([
                    'estado' => 'en_revision',
                ]);
            }
        }

        return ApiResponse::success([
            'suscripcion_id' => $suscripcion->id,
            'plan'           => $plan->nombre_plan,
            'en_revision'    => true,
        ], '¡Comprobante recibido! Tu solicitud está En Revisión. El Superadmin te notificará pronto.');
    }
}
