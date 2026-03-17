<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Storage;

class RenovarSuscripcionController extends Controller
{
    /**
     * El gerente solicita renovación de su suscripción:
     * - Puede hacerlo MIENTRAS su suscripción actual sigue activa.
     * - Se crea una NUEVA suscripción en estado 'pendiente'.
     * - El superadmin la revisará y la aprobará, activándola al vencer la actual.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // 1. Si la ruta no corre bajo auth:sanctum, intentar resolver el token manualmente
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

        // Suscripción única: siempre actualizamos la fila existente o creamos una si mágicamente no existiera
        $suscripcionActiva = $cafeteria->suscripciones()->first();

        // Calcular fechas de la suscripción
        if ($suscripcionActiva && $suscripcionActiva->estado_pago === 'pagado' && \Carbon\Carbon::parse($suscripcionActiva->fecha_fin)->isFuture()) {
            $inicio = \Carbon\Carbon::parse($suscripcionActiva->fecha_fin)->startOfDay()->addDay();
        } else {
            $inicio = now()->startOfDay();
        }
        $fin = $inicio->copy()->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

        // Guardar el nuevo comprobante
        $path = $request->file('comprobante')->store('comprobantes');

        if ($suscripcionActiva && $suscripcionActiva->comprobante_url) {
            \Storage::delete($suscripcionActiva->comprobante_url);
        }

        $suscripcion = Suscripcion::updateOrCreate(
            ['cafe_id' => $cafeteria->id],
            [
                'plan_id'         => $plan->id,
                'user_id'         => $user->id,
                'fecha_inicio'    => $inicio,
                'fecha_fin'       => $fin,
                'monto'           => $plan->precio,
                'comprobante_url' => $path,
                'estado_pago'     => 'pendiente',
            ]
        );

        return ApiResponse::success([
            'suscripcion_id' => $suscripcion->id,
            'plan'           => $plan->nombre_plan,
            'fecha_inicio'   => $inicio->toDateString(),
            'fecha_fin'      => $fin->toDateString(),
        ], '¡Recibido! Espera a que el Superadmin te apruebe.');
    }

}
