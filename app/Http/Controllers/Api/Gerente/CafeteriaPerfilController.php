<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class CafeteriaPerfilController extends Controller
{
    /**
     * ACCIONES DEL GERENTE
     */

    //Ver mi cafetería
    public function show(Request $request)
    {
        return ApiResponse::success(
            $request->user()->cafeteria,
            'Perfil cafetería'
        );
    }

    //Actualizar mi cafetería
    public function update(Request $request)
    {

           
        $cafeteria=$request->user()->cafeteria;

        //seguridad
        if(!$cafeteria){
            return ApiResponse::error(
                'El usuario no tiene cafetería asignada',
                404
            );
        }


        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'descripcion'=>'nullable|string|max:255',
            'calle'=>'nullable|string|max:100',
            'num_exterior'=>'nullable|string|max:10',
            'num_interior'=>'nullable|string|max:10',
            'colonia'=>'nullable|string|max:80',
            'estado_republica'=>'nullable|string|max:80',
            'municipio'=>'nullable|string|max:80',
            'cp'=>'nullable|string|max:10',
            'telefono'=>'nullable|string|max:20',
            'estado'=>'sometimes|in:activa,suspendida,pendiente',
            'foto_url'=>'nullable|string|max:255'
        ]);

        $cafeteria->update($data);

        $cafeteria->refresh(); //Devuelve los datos actualizados

        return ApiResponse::success(
            $cafeteria,
            'Cafetería actualizada correctamente'
        );
    }

}
