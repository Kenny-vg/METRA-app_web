<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    /*
        LOGIN
        Autentica usuario y crea token seguro para la API
    */
    public function login(Request $request)
    {
        //validación básica
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        //Buscar usuario por email
        $user = User::where('email', $request->email)->first();

        //Si no existe o la password es incorrecta
        if(!$user|| !Hash::check($request->password, $user->password)){
            return ApiResponse::error('Credenciales incorrectas', 401);
        }

        //Si el usuario está inactivo
        if(!$user->estado){
            return ApiResponse::error(
                'Usuario inactivo',
                403
            );
        }

        //crear token para usar la API
        $token = $user->createToken('metra_token')->plainTextToken;

        //Devolver datos del usuario y token
        return ApiResponse::success([
            'token' => $token,
            'usuario'=>[
                'id'=> $user->id,
                'name'=> $user->name,
                'role'=> $user->role,
                'cafe_id'=>$user->cafe_id
            ]
        ], 'Login correcto');
    }

    /*
      PERFIL
      Devuelve usuario autenticado usando token
    */
    public function miPerfil(Request $request)
    {
        //usuario obtenido desde el token
        $user = $request->user();

        return ApiResponse::success([
            'usuario' => [
                'id'=> $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'role'=>$user->role,
                'cafe_id'=>$user->cafe_id
            ]
        ]);
    }

    /*
        LOGOUT
        Elimina token actual
    */
    public function logout(Request $request)
    {
        //eliminar token usado actualmente
        $token=$request->user()->currentAccessToken();

        if($token){
            $token->delete();
        }

        return ApiResponse::success(
            null,
            'Sesión cerrada'
        );
    }

    /*
      Activar la cuenta del gerente
    */

    public function activarCuenta(Request $request)
    {
        $data = $request->validate([
            'email'=>'required|email',
            'token'=>'required',
            'password'=>'required|min:6'
        ]);

        //buscar usuario por token
        $user = User::where('email',$data['email'])
            ->where('activation_token', $data['token'])
            ->first();

        //si no existe el token
        if(!$user){
            return ApiResponse::error(
                'Token inválido o expirado',
                400
            );
        }

        //activar cuenta
        $user->update([
            'password'=>Hash::make($data['password']),
            'estado'=>true,
            'activation_token'=>null,
            'must_change_password'=>false
        ]);

        return ApiResponse::success(
            null,
            'Cuenta activada correctamente'
        );
    }

    /*-----------------
       REGISTRO CLIENTE
    -----------------*/

    public function registerCliente(Request $request)
    {
        //validaciones básicas
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'
        ]);

        //crear usuario cliente
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),

            //seguridad
            'role'=>'cliente',
            'cafe_id'=>null,
            'estado'=>true
        ]);

        return ApiResponse::success([
            'usuario'=>[
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->role
            ]
            ], 'Cuenta creada correctamente');

    }


}
