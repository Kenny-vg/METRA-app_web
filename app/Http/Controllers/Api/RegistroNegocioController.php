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
            'gerente.email'    => 'required|email|unique:users,email',

            'plan_id'          => 'required|exists:planes,id',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $result = DB::transaction(function () use ($data, $plan) {
            // 1. Crear cafetería en estado "en_revision"
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

            // 2. Crear el gerente/dueño (inactivo hasta que se apruebe)
            $token = Str::random(60);
            $gerente = User::create([
                'name'                => $data['gerente']['name'],
                'email'               => $data['gerente']['email'],
                'password'            => null,
                'role'                => 'gerente',
                'cafe_id'             => $cafeteria->id,
                'estado'              => false,
                'activation_token'    => $token,
                'must_change_password'=> true,
            ]);

            // 3. Vincular cafetería con el gerente
            $cafeteria->update(['user_id' => $gerente->id]);

            // 4. Crear suscripción pendiente
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

            // 5. Enviar correo de activación (cuando el superadmin apruebe)
            // Por ahora guardamos el token y enviamos el correo al aprobarse
            // Mail::to($gerente->email)->send(new ActivacionCuentaMail($token, $gerente->email));

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

        // Guardar archivo
        $path = $request->file('comprobante')->store('comprobantes', 'public');

        $cafeteria->update([
            'comprobante_url' => $path,
        ]);

        return ApiResponse::success(
            ['comprobante_url' => Storage::url($path)],
            'Comprobante subido correctamente. El equipo revisará tu solicitud.'
        );
    }
}
