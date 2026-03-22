<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Storage;

class CafeteriaPerfilController extends Controller
{
    /**
     * ACCIONES DEL GERENTE
     */

    //Ver mi cafetería
    public function show(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;

        if ($cafeteria) {
            $cafeteria->load(['suscripcionActual.plan']);
        }

        return ApiResponse::success(
            $cafeteria,
            'Perfil cafetería'
        );
    }



    //Actualizar mi cafetería
    public function update(Request $request)
    {
        $camposTexto = ['nombre', 'descripcion', 'calle', 'num_exterior', 'num_interior', 'colonia', 'estado_republica', 'municipio'];
        foreach ($camposTexto as $campo) {
            if ($request->has($campo) && !empty($request->$campo)) {
                $request->merge([$campo => strip_tags($request->$campo)]);
            }
        }

        $cafeteria = $request->user()->cafeteria;

        //seguridad
        if (!$cafeteria) {
            return ApiResponse::error(
                'El usuario no tiene cafetería asignada',
                404
            );
        }


        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:100',
            'num_exterior' => 'nullable|string|max:10',
            'num_interior' => 'nullable|string|max:10',
            'colonia' => 'nullable|string|max:80',
            'estado_republica' => 'nullable|string|max:80',
            'municipio' => 'nullable|string|max:80',
            'cp' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'porcentaje_reservas' => 'sometimes|integer|min:0|max:100',
            'duracion_reserva_min' => 'sometimes|integer|min:15|max:240',
            'intervalo_reserva_min' => 'sometimes|integer|min:15|max:120',
        ]);

        if ($request->hasFile('foto')) {
            // borrar foto anterior
            if ($cafeteria->foto_url) {
                Storage::disk('public')->delete($cafeteria->foto_url);
            }

            $path = $request->file('foto')->store('cafeterias', 'public');

            $data['foto_url'] = $path;
        }
        $cafeteria->update($data);

        $cafeteria->refresh(); //Devuelve los datos actualizados

        return ApiResponse::success(
            $cafeteria,
            'Cafetería actualizada correctamente'
        );
    }

}
