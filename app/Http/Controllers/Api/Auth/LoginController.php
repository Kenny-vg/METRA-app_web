<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
    $request->validate([
        'email'=>'required|email',
        'password'=>'required'
    ]);

    $user = User::where('email',$request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)){
        return ApiResponse::error('Credenciales incorrectas', 401);
    }

    if(!$user ->estado){
        return ApiResponse::error('Usuario inactivo', 403);
    }
    //bloquear acceso si la cafeteria no tiene suscripción activa
    if(in_array($user->role,['gerente','personal'])){
        $cafeteria=$user->cafeteria;
        if(!$cafeteria||!$cafeteria->suscripcionActual){
            return ApiResponse::error(
                'La suscripción de tu cafeteria ha vencido', 
                403);
        }
    }

    $token = $user->createToken('metra_token')->plainTextToken;

    return ApiResponse::success([
        'token'=>$token,
        'usuario'=>[
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
            'cafe_id'=>$user->cafe_id
        ]
    ], 'Login correcto');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if($token){
            $token->delete();
        }
        return ApiResponse::success(null, 'Sesión cerrada');
    }
}
