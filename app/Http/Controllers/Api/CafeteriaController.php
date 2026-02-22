<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class CafeteriaController extends Controller
{
    /**
     *  Listar cafeterias (superadmin)
     */
    public function index()
    {
        return ApiResponse::success(
            Cafeteria::all(),
            'Listado de cafeterias'
        );
    }

    /**
     * Crear cafetería y dar de alta al gerente (superadmin).
     */
    public function store(Request $request)
    {
        //validación de datos
        $data = $request->validate([
                'nombre'=>'required|string|max:100',

                //datos del gerente
                'gerente.name'=>'required|string|max:100',
                'gerente.email'=>'required|email|unique:users,email',
                'gerente.password'=>'required|string|min:6',
                
            ]);

            //transacción db
            $result = DB::transaction(function() use($data){
                //crear cafeteria
                $cafeteria = Cafeteria::create([
                    'nombre' => $data['nombre']
                ]);

                //crear gerente
                $gerente = User::create([
                    'name'=> $data['gerente']['name'],
                    'email'=>$data['gerente']['email'],
                    'password'=> Hash::make($data['gerente']['password']),

                    //seguridad
                    'role'=>'gerente',

                    //vinculación automática
                    'cafe_id'=>$cafeteria->id,
                    'estado'=>true
                ]);

                return[
                    'cafeteria'=>$cafeteria,
                    'gerente'=>$gerente
                ];
            });

            return ApiResponse::success(
                $result,
                'Cafetería y gerente creados correctamente'
            );
    }


    /**
     * Actualizar cafetería
     */
    public function update(Request $request, Cafeteria $cafeteria)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
        ]);

        $cafeteria->update($data);

        $cafeteria->refresh();

        return ApiResponse::success(
            $cafeteria,
            'Cafetería actualizada'
        );
    }

    /**
     * Eliminar
     */
    public function destroy(Cafeteria $cafeteria)
    {
        // elimina SOLO la cafetería recibida
        if (!$cafeteria->exists) {
        return ApiResponse::error(
            'Cafetería no encontrada',
            404
        );
    }

        $cafeteria->delete();

        return ApiResponse::success(
            null,
            'Cafetería eliminada'
        );
    }
}
