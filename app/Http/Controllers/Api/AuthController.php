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
    
}
