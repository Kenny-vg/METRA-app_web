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

    if(!$user->estado && $user->role === 'gerente'){

        // 1. Prioridad: Si el registro fue rechazado
        if($user->estatus_registro === 'rechazado'){
            return ApiResponse::error(
                'Tu registro ha sido rechazado. Por favor contacta a soporte para más información.',
                403
            );
        }

        $cafeteria = $user->cafeteria;
        $suscripcion = $cafeteria
            ? $cafeteria->suscripciones()->latest()->first()
            : null;

        if(!$suscripcion){
            return ApiResponse::error(
                'Tu suscripción aún no ha sido creada.',
                423
            );
        }

        // Si NO ha subido comprobante
        if(!$suscripcion->comprobante_url){
            return ApiResponse::error(
                'Debes subir tu comprobante para continuar.',
                423
            );
        }

        // Si la suscripción sigue pendiente
        if($suscripcion->estado_pago === 'pendiente'){
            return ApiResponse::error(
                'Tu comprobante fue enviado. Espera la validación del superadmin.',
                423
            );
        }
    }

    //bloquear acceso si la cafeteria no tiene suscripción activa
    if(in_array($user->role,['gerente','personal'])){

        $cafeteria = $user->cafeteria;

        if(!$cafeteria){
            return ApiResponse::error(
                'No tienes una cafetería asociada.',
                403
            );
        }

        $suscripcion = $cafeteria->suscripciones()
            ->latest()
            ->first();

        if(!$suscripcion){
            return ApiResponse::error(
                'Tu suscripción aún no ha sido creada.',
                403
            );
        }

        //  Bloquear si está pendiente
        if($suscripcion->estado_pago !== 'pagado'){

            if($user->role === 'gerente'){
                return ApiResponse::error(
                    'Tu suscripción está pendiente de aprobación. Por favor espera la validación del superadmin.',
                    423
                );
            }

            // Si es personal (staff)
            return ApiResponse::error(
                'La cafetería aún no ha sido aprobada. Contacta al gerente.',
                403
            );
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
