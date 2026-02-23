<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivacionCuentaMail;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

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
                'gerente.email'=>'required|email|unique:users,email'
            ]);

            //transacción db
            $result = DB::transaction(function() use($data){
                //crear cafeteria
                $cafeteria = Cafeteria::create([
                    'nombre' => $data['nombre']
                ]);

                //generar token seguro
                $token = Str::random(60);

                //crear gerente
                $gerente = User::create([
                    'name'=> $data['gerente']['name'],
                    'email'=>$data['gerente']['email'],
                    'password'=>null,

                    //seguridad
                    'role'=>'gerente',

                    //vinculación automática
                    'cafe_id'=>$cafeteria->id,
                    'estado'=>false,
                    'activation_token'=>$token,
                    'must_change_password'=>true
                ]);

                //enviar correo de activación
                Mail::to($gerente->email)->send(
                    new ActivacionCuentaMail($token, $gerente->email)
                );

                return[
                    'cafeteria'=>$cafeteria,
                    'gerente'=>[
                        'name'=>$gerente->name,
                        'email'=>$gerente->email
                    ]
                ];
            });

            return ApiResponse::success(
                $result,
                'Cafetería creada. Se envió un correo de activación al gerente.'
            );
    }


    /**
     * Actualizar cafetería
     */
    public function update(Request $request, Cafeteria $cafeteria)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'descripcion'=>'nullable|string|max:255',
            'calle'=>'nullable|string|max:100',
            'numero_exterior'=>'nullable|string|max:10',
            'numero_interior'=>'nullable|string|max:10',
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
