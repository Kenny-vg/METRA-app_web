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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $data = $request->validate([
            'nombre'           => 'required|string|max:100',
            'descripcion'      => 'nullable|string|max:255',
            'calle'            => 'nullable|string|max:100',
            'num_exterior'     => 'nullable|string|max:10',
            'num_interior'     => 'nullable|string|max:10',
            'colonia'          => 'nullable|string|max:80',
            'ciudad'           => 'nullable|string|max:80',
            'estado_republica' => 'nullable|string|max:80',
            'cp'               => 'nullable|string|max:10',
            'telefono'         => 'nullable|string|max:20',

            'gerente.name'     => 'required|string|max:100',
            'gerente.email' => [
                'required',
                'email',
                Rule::unique('users','email')
                    ->where(function ($query) {
                        return $query->whereIn('estatus_registro', [
                            'aprobado',
                            'rechazado',
                            'desactivado'
                        ]);
                    }),
            ],
            'gerente.password' => 'required|string|min:8|confirmed',

            'plan_id'          => 'required|exists:planes,id',
        ], [
            'nombre.required' => 'El nombre del negocio es obligatorio.',
            'gerente.name.required' => 'El nombre del gerente es obligatorio.',
            'gerente.email.required' => 'El correo corporativo es obligatorio.',
            'gerente.email.email' => 'El correo corporativo no tiene un formato válido.',
            'gerente.email.unique' => 'El correo ya se encuentra registrado en el sistema. Inicia sesión o usa otro.',
            'gerente.password.required' => 'La contraseña es obligatoria.',
            'gerente.password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'gerente.password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'plan_id.required' => 'Debe seleccionar un plan de suscripción válido.',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $result = DB::transaction(function () use ($data, $plan) {

            $gerenteExistente = User::where('email', $data['gerente']['email'])
                ->where('estatus_registro', 'pendiente')
                ->first();

            // 1. Crear cafetería en estado "en_revision" pero si ya existe una cafetería con ese correo, se actualiza
            if ($gerenteExistente && $gerenteExistente->cafe_id) {

                $cafeteria = Cafeteria::find($gerenteExistente->cafe_id);

                $cafeteria->update([
                    'nombre'           => $data['nombre'],
                    'descripcion'      => $data['descripcion'] ?? null,
                    'calle'            => $data['calle'] ?? null,
                    'num_exterior'     => $data['num_exterior'] ?? null,
                    'num_interior'     => $data['num_interior'] ?? null,
                    'colonia'          => $data['colonia'] ?? null,
                    'ciudad'           => $data['ciudad'] ?? null,
                    'estado_republica' => $data['estado_republica'] ?? null,
                    'cp'               => $data['cp'] ?? null,
                    'telefono'         => $data['telefono'] ?? null,
                ]);

            } else {

                $cafeteria = Cafeteria::create([
                    'nombre'           => $data['nombre'],
                    'descripcion'      => $data['descripcion'] ?? null,
                    'calle'            => $data['calle'] ?? null,
                    'num_exterior'     => $data['num_exterior'] ?? null,
                    'num_interior'     => $data['num_interior'] ?? null,
                    'colonia'          => $data['colonia'] ?? null,
                    'ciudad'           => $data['ciudad'] ?? null,
                    'estado_republica' => $data['estado_republica'] ?? null,
                    'cp'               => $data['cp'] ?? null,
                    'telefono'         => $data['telefono'] ?? null,
                    'estado'           => 'en_revision',
                ]);
            }

            // 2. Crear el gerente/dueño (inactivo hasta que se apruebe)
            
            if ($gerenteExistente) {

                $gerenteExistente->update([
                    'name' => $data['gerente']['name'],
                    'password' => Hash::make($data['gerente']['password']),
                    'role' => 'gerente',
                    'cafe_id' => $cafeteria->id,
                ]);

                $gerente = $gerenteExistente;

            } else {

                $gerente = User::create([
                    'name'     => $data['gerente']['name'],
                    'email'    => $data['gerente']['email'],
                    'password' => Hash::make($data['gerente']['password']),
                    'role'     => 'gerente',
                    'cafe_id'  => $cafeteria->id,
                    'estado'   => false,
                    'estatus_registro' => 'pendiente'
                ]);
}

            // 3. Vincular cafetería con el gerente
            $cafeteria->update(['user_id' => $gerente->id]);

            // 4. Crear suscripción pendiente
            Suscripcion::where('cafe_id', $cafeteria->id)
                ->where('estado_pago', 'pendiente')
                ->delete();
                
            $inicio = now();
            $fin    = $inicio->copy()->addDays($plan->duracion_dias);
            Suscripcion::create([
                'cafe_id'     => $cafeteria->id,
                'plan_id'     => $plan->id,
                'user_id'     => $gerente->id,
                'fecha_inicio'=> $inicio,
                'fecha_fin'   => $fin,
                'estado_pago' => 'pendiente',
                'monto'       => $plan->precio,
            ]);


            return [
                'cafeteria_id' => $cafeteria->id,
                'gerente'      => [
                    'name'  => $gerente->name,
                    'email' => $gerente->email,
                ],
                'plan'         => $plan->nombre_plan,
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
        $request->validate([
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {

            $file = $request->file('comprobante');

            // Asegurar que use el disco public
            $path = $file->store('comprobantes', 'public');

            $cafeteria->update([
                'comprobante_url' => $path
            ]);

            $suscripcion = $cafeteria->suscripciones()->latest()->first();
            if ($suscripcion) {
                $suscripcion->update([
                    'comprobante_url' => $path
                ]);
            }

            return ApiResponse::success(
                ['comprobante_url' => $path],
                'Comprobante subido correctamente.'
            );

        } catch (\Throwable $e) {

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

        $user = User::where('email', $request->email)
            ->where('estatus_registro', 'pendiente')
            ->where('role', 'gerente')
            ->whereNotNull('cafe_id')
            ->first();

        if(!$user){
            return ApiResponse::error('No hay registro pendiente', 404);
        }

        return ApiResponse::success([
            'cafeteria_id' => $user->cafe_id,
            'nombre_cafeteria' => optional($user->cafeteria)->nombre,
        ], 'Registro pendiente encontrado');
    }


}
