<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\User;
use App\Helpers\ApiResponse;
use App\Mail\ActivacionCuentaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\CloudinaryService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistroNegocioController extends Controller
{
    /**
     * Devuelve los planes activos (público, sin autenticación).
     */
    public function planesPublicos()
    {
        $planes = Plan::where('estado', true)
            ->orderBy('precio')
            ->get();

        return ApiResponse::success($planes, 'Planes disponibles');
    }

    /**
     * Auto-registro de un negocio por el propio gerente/dueño.
     * Crea: Cafetería (en_revision) + Gerente (inactivo) + Suscripción (pendiente).
     */
    public function store(Request $request)
    {
        // 1. CHECAR SI ES RECHAZADO ANTES DE VALIDAR 
        $email = $request->input('gerente.email') ?: $request->input('email');
        if ($email) {
            $userRechazado = User::where('email', $email)
                ->where('estatus_registro', 'rechazado')
                ->first();

            if ($userRechazado) {
                return ApiResponse::error(
                    'Este correo ya fue utilizado en un registro que fue rechazado. Contacta a soporte para más información.',
                    403
                );
            }
        }

        // Limpiar inputs de HTML (Protección XSS)
        $request->merge([
            'nombre' => $request->filled('nombre') ? strip_tags($request->nombre) : null,
            'descripcion' => $request->filled('descripcion') ? strip_tags($request->descripcion) : null,
            'calle' => $request->filled('calle') ? strip_tags($request->calle) : null,
            'num_exterior' => $request->filled('num_exterior') ? strip_tags($request->num_exterior) : null,
            'num_interior' => $request->filled('num_interior') ? strip_tags($request->num_interior) : null,
            'colonia' => $request->filled('colonia') ? strip_tags($request->colonia) : null,
            'ciudad' => $request->filled('ciudad') ? strip_tags($request->ciudad) : null,
            'estado_republica' => $request->filled('estado_republica') ? strip_tags($request->estado_republica) : null,

            // Si el nombre del gerente viene en un array
            'gerente' => $request->has('gerente') && is_array($request->gerente) ? array_merge($request->gerente, [
                'name' => isset($request->gerente['name']) ? strip_tags($request->gerente['name']) : null
            ]) : $request->gerente
        ]);

        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:100',
            'num_exterior' => 'nullable|string|max:10',
            'num_interior' => 'nullable|string|max:10',
            'colonia' => 'nullable|string|max:80',
            'ciudad' => 'nullable|string|max:80',
            'estado_republica' => 'nullable|string|max:80',
            'cp' => 'nullable|regex:/^\d{5}$/',
            'telefono' => 'nullable|regex:/^[0-9\s\-\+\(\)]{8,20}$/',

            'gerente.name' => 'required|string|max:100',
            'gerente.email' => [
                'required',
                Rule::unique('users', 'email')->where(function ($query) {
            return $query->where('estatus_registro', '!=', 'pendiente');
        }),
            ],
            'gerente.password' => 'required|string|min:8|confirmed',

            'plan_id' => 'required|exists:planes,id,estado,1',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        // Normalizar correo a minúsculas
        $data['gerente']['email'] = strtolower(trim($data['gerente']['email']));

        // Verificar si ya existe registro pendiente
        $gerenteExistente = User::where('email', $data['gerente']['email'])
            ->where('estatus_registro', 'pendiente')
            ->where('role', 'gerente')
            ->first();

        if ($gerenteExistente) {

            $cafeteria = $gerenteExistente->cafeteria;

            // si ya subió comprobante → bloquear
            if ($cafeteria && $cafeteria->comprobante_url) {
                return ApiResponse::error(
                    'Tu comprobante ya fue enviado y está en revisión.',
                    409,
                ['cafeteria_id' => $cafeteria->id]
                );
            }

            // si no existe la cafeteria (inconsistencia), crearla
            if (!$cafeteria) {
                $cafeteria = Cafeteria::create([
                    'nombre' => $data['nombre'],
                    'user_id' => $gerenteExistente->id,
                    'estado' => 'en_revision'
                ]);
                $gerenteExistente->update(['cafe_id' => $cafeteria->id]);
            }

            // actualizar datos mientras no haya comprobante
            $cafeteria->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'calle' => $data['calle'] ?? null,
                'num_exterior' => $data['num_exterior'] ?? null,
                'num_interior' => $data['num_interior'] ?? null,
                'colonia' => $data['colonia'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'estado_republica' => $data['estado_republica'] ?? null,
                'cp' => $data['cp'] ?? null,
                'telefono' => $data['telefono'] ?? null,
            ]);

            $gerenteExistente->update([
                'name' => $data['gerente']['name'],
                'password' => Hash::make($data['gerente']['password']),
            ]);

            $suscripcion = $cafeteria->suscripciones()->latest()->first();

            if ($suscripcion) {
                if ($suscripcion->plan_id != $data['plan_id']) {
                    $inicio = now()->startOfDay();
                    $fin = $inicio->copy()->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

                    $suscripcion->update([
                        'plan_id' => $plan->id,
                        'fecha_inicio' => $inicio,
                        'fecha_fin' => $fin,
                        'monto' => $plan->precio
                    ]);
                }
            }
            else {
                // Fallback crucial: si el intento anterior falló antes de crear la suscripción, se crea ahora
                $inicio = now()->startOfDay();
                $fin = $inicio->copy()->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

                Suscripcion::create([
                    'cafe_id' => $cafeteria->id,
                    'plan_id' => $plan->id,
                    'user_id' => $gerenteExistente->id,
                    'fecha_inicio' => $inicio,
                    'fecha_fin' => $fin,
                    'estado_pago' => 'pendiente',
                    'monto' => $plan->precio,
                ]);
            }

            return ApiResponse::success([
                'cafeteria_id' => $cafeteria->id,
                'registro_existente' => true
            ], 'Registro actualizado. Continúa con el comprobante.');
        }

        $result = DB::transaction(function () use ($data, $plan) {

            // Crear cafetería
            $cafeteria = Cafeteria::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'calle' => $data['calle'] ?? null,
                'num_exterior' => $data['num_exterior'] ?? null,
                'num_interior' => $data['num_interior'] ?? null,
                'colonia' => $data['colonia'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'estado_republica' => $data['estado_republica'] ?? null,
                'cp' => $data['cp'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'estado' => 'en_revision',
            ]);

            // Crear gerente
            $gerente = User::create([
                'name' => $data['gerente']['name'],
                'email' => $data['gerente']['email'],
                'password' => Hash::make($data['gerente']['password']),
                'role' => 'gerente',
                'cafe_id' => $cafeteria->id,
                'estado' => false,
                'estatus_registro' => 'pendiente'
            ]);

            // Vincular gerente a cafetería
            $cafeteria->update([
                'user_id' => $gerente->id
            ]);

            // Crear suscripción pendiente
            $inicio = now()->startOfDay();
            $fin = $inicio->copy()->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

            Suscripcion::create([
                'cafe_id' => $cafeteria->id,
                'plan_id' => $plan->id,
                'user_id' => $gerente->id,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
                'estado_pago' => 'pendiente',
                'monto' => $plan->precio,
            ]);

            return [
            'cafeteria_id' => $cafeteria->id,
            'gerente' => [
            'name' => $gerente->name,
            'email' => $gerente->email,
            ],
            'plan' => $plan->nombre_plan,
            ];
        });

        return ApiResponse::success(
            $result,
            'Solicitud recibida. Por favor sube tu comprobante de pago.'
        );
    }

    /**
     * Subir el comprobante de transferencia.
     */
    public function subirComprobante(Request $request, Cafeteria $cafeteria)
    {
        // Evitar subir comprobante si ya existe uno
        if ($cafeteria->comprobante_url) {
            return ApiResponse::error(
                'El comprobante ya fue enviado y está en revisión por el administrador.',
                409
            );
        }

        $request->validate([
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {

            $file = $request->file('comprobante');

            $uploaded = CloudinaryService::upload($file, 'metra/comprobantes');

            if (!$uploaded) {
                return ApiResponse::error('Error al subir el comprobante a la nube', 500);
            }

            $path = $uploaded['url'];
            $publicId = $uploaded['public_id'];

            $cafeteria->update([
                'comprobante_url' => $path,
                'comprobante_public_id' => $publicId
            ]);

            $suscripcion = $cafeteria->suscripciones()->latest()->first();
            if ($suscripcion) {
                $suscripcion->update([
                    'comprobante_url' => $path,
                    'comprobante_public_id' => $publicId
                ]);
            }

            return ApiResponse::success(
                ['comprobante_url' => $path],
                'Comprobante subido correctamente.'
            );

        }
        catch (\Throwable $e) {

            \Log::error("Error al subir comprobante: " . $e->getMessage());

            return ApiResponse::error(
                'Error interno al subir el comprobante.',
                500
            );
        }
    }

    public function registroPendiente(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $email = strtolower(trim($request->email));

        $gerenteRechazado = User::where('email', $email)
            ->where('estatus_registro', 'rechazado')
            ->where('role', 'gerente')
            ->first();

        if ($gerenteRechazado) {
            return ApiResponse::error(
                'Este correo ya fue utilizado en un registro que fue rechazado. Contacta a soporte para más información.',
                403
            );
        }

        $user = User::where('email', $email)
            ->where('estatus_registro', 'pendiente')
            ->where('role', 'gerente')
            ->whereNotNull('cafe_id')
            ->first();

        if (!$user) {
            return ApiResponse::error('No hay registro pendiente', 404);
        }

        return ApiResponse::success([
            'cafeteria_id' => $user->cafe_id,
            'nombre_cafeteria' => optional($user->cafeteria)->nombre,
        ], 'Registro pendiente encontrado');
    }


}
