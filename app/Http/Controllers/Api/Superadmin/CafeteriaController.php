<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

        //validación
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'gerente.name' => 'required|string|max:100',
            'gerente.email'=> 'required|email|unique:users,email',
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $result = DB::transaction(function () use ($data) {
            $cafeteria = Cafeteria::create([
                'nombre' => $data['nombre'],
                'estado' => 'activa',
            ]);

            $gerente = User::create([
                'name'                => $data['gerente']['name'],
                'email'               => $data['gerente']['email'],
                'password'            => Hash::make(Str::random(40)),
                'role'                => 'gerente',
                'cafe_id'             => $cafeteria->id,
                'estado'              => false,
                
            ]);

            $cafeteria->update(['user_id' => $gerente->id]);


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
            'Cafetería creada correctamente.'
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

        // aprobado
        if ($data['estado'] === 'activa' && $cafeteria->gerente) {
            
            //activar gerente
            $cafeteria->gerente->update([
                'estado'=> 1 //true
            ]);

            //actualizar suscripcion a pagado
            optional($cafeteria->suscripcionActual)->update([
                'estado_pago'      => 'pagado',
                'fecha_validacion' => now(),
            ]);
        } 
            
        // Si se rechaza/suspende: desactivar gerente
        if ($data['estado'] === 'suspendida' && $cafeteria->gerente) {
            $cafeteria->gerente->update([
                'estado' => 0 //false
            ]);

            // cancelar suscripción
            optional($cafeteria->suscripcionActual)->update([
                'estado_pago' => 'cancelado'
            ]);
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


    public function show(Cafeteria $cafeteria)
    {
        $cafeteria->load([
            'gerente',
            'suscripcionActual.plan'
        ]);

        return ApiResponse::success(
            $cafeteria,
            'Detalle de cafetería'
        );
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
