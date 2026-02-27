<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\User;
use App\Mail\ActivacionCuentaMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class CafeteriaController extends Controller
{
    /**
     * Listar cafeterías con gerente y suscripción (superadmin)
     */
    public function index(Request $request)
    {
        $query = Cafeteria::with(['gerente', 'suscripcionActual.plan']);

        // Filtrar por estado si se pasa como parámetro
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        return ApiResponse::success(
            $query->get(),
            'Listado de cafeterías'
        );
    }

    /**
     * Crear cafetería y dar de alta al gerente (superadmin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'gerente.name' => 'required|string|max:100',
            'gerente.email'=> 'required|email|unique:users,email',
        ]);

        $result = DB::transaction(function () use ($data) {
            $cafeteria = Cafeteria::create([
                'nombre' => $data['nombre'],
                'estado' => 'activa',
            ]);

            $token = Str::random(60);

            $gerente = User::create([
                'name'                => $data['gerente']['name'],
                'email'               => $data['gerente']['email'],
                'password'            => Hash::make($data['gerente']['password']),
                'role'                => 'gerente',
                'cafe_id'             => $cafeteria->id,
                'estado'              => false,
            ]);

            $cafeteria->update(['user_id' => $gerente->id]);

            Mail::to($gerente->email)->send(
                new ActivacionCuentaMail($token, $gerente->email)
            );

            return [
                'cafeteria' => $cafeteria,
                'gerente'   => [
                    'name'  => $gerente->name,
                    'email' => $gerente->email,
                ],
            ];
        });

        return ApiResponse::success(
            $result,
            'Cafetería creada. Se envió un correo de activación al gerente.'
        );
    }

    /**
     * Cambiar el estado de una cafetería (superadmin).
     * Usado para aprobar/rechazar registros en revisión.
     */
    public function cambiarEstado(Request $request, Cafeteria $cafeteria)
    {
        $data = $request->validate([
            'estado' => 'required|in:activa,suspendida,pendiente,en_revision',
        ]);

        $cafeteria->update(['estado' => $data['estado']]);

        // Si se aprueba: activar al gerente y enviarle el correo de activación
        if ($data['estado'] === 'activa' && $cafeteria->gerente) {
            $gerente = $cafeteria->gerente;

            $gerente->update([
                'estado'=> true
            ]);

            if (!$gerente->activation_token) {
                // Generar nuevo token de activación si no tiene
                $token = Str::random(60);

                $gerente->update([
                    'activation_token' => $token,
                ]);

                Mail::to($gerente->email)->send(
                    new ActivacionCuentaMail($token, $gerente->email)
                );
            }

            // Actualizar suscripción a pagado
            optional($cafeteria->suscripcionActual)->update([
                'estado_pago'      => 'pagado',
                'fecha_validacion' => now(),
            ]);
        }

        // Si se rechaza/suspende: desactivar gerente
        if (in_array($data['estado'], ['suspendida']) && $cafeteria->gerente) {
            $cafeteria->gerente->update(['estado' => false]);
        }

        $cafeteria->load(['gerente', 'suscripcionActual.plan']);

        return ApiResponse::success(
            $cafeteria,
            'Estado de cafetería actualizado correctamente'
        );
    }

    /**
     * Ver URL del comprobante de pago (superadmin).
     */
    public function verComprobante(Cafeteria $cafeteria)
    {
        if (!$cafeteria->comprobante_url) {
            return ApiResponse::error('Esta cafetería no tiene comprobante subido', 404);
        }

        return ApiResponse::success([
            'comprobante_url' => Storage::url($cafeteria->comprobante_url),
            'cafeteria'       => $cafeteria->nombre,
        ], 'Comprobante encontrado');
    }

    /**
     * Eliminar cafetería
     */
    public function destroy(Cafeteria $cafeteria)
    {
        if (!$cafeteria->exists) {
            return ApiResponse::error('Cafetería no encontrada', 404);
        }

        $cafeteria->delete();

        return ApiResponse::success(null, 'Cafetería eliminada');
    }
}
