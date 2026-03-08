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

    if($user->estatus_registro === 'rechazado'){
        return ApiResponse::error(
            'Tu registro ha sido rechazado. Contacta a soporte.',
            403
        );
    }

    if($user->estatus_registro === 'pendiente'){

        $cafeteria = $user->cafeteria;

        if(!$cafeteria){
            return ApiResponse::error(
                'No tienes una cafetería asociada.',
                423
            );
        }

        $suscripcion = $cafeteria->suscripciones()
            ->orderByDesc('id')
            ->first();

        if(!$suscripcion){
            return ApiResponse::error(
                'Debes subir tu comprobante para continuar.',
                423
            );
        }

        if(empty($suscripcion->comprobante_url) && empty($cafeteria->comprobante_url)){
            return ApiResponse::error(
                'Debes subir tu comprobante para continuar.',
                423
            );
        }

        if($suscripcion->estado_pago === 'pendiente'){
            return ApiResponse::error(
                'Tu comprobante fue enviado. Espera la validación del superadmin.',
                423
            );
        }
    }
}

    if(!$user->estado){
        return ApiResponse::error('Usuario inactivo', 403);
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
                'Tu cuenta está en revisión.',
                423
            );
        }

        //  Bloquear si está pendiente
        if($suscripcion->estado_pago !== 'pagado'){

            if($user->role === 'gerente'){
                return ApiResponse::error(
                    'Tu cuenta está en revisión.',
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

    // Datos extra para sidebar y banner de suscripción
    $extraData = [];
    if (in_array($user->role, ['gerente', 'personal'])) {
        $cafeteria = $user->cafeteria;
        if ($cafeteria) {
            $extraData['nombre_cafeteria'] = $cafeteria->nombre;
            $suscActiva = $cafeteria->suscripcionActual()->first();
            if ($suscActiva && $suscActiva->fecha_fin) {
                $extraData['dias_restantes'] = (int) now()->startOfDay()->diffInDays(
                    \Carbon\Carbon::parse($suscActiva->fecha_fin)->startOfDay(),
                    false
                );
                $extraData['fecha_fin_suscripcion'] = $suscActiva->fecha_fin;
            } else {
                $extraData['dias_restantes'] = null;
                $extraData['fecha_fin_suscripcion'] = null;
            }
        }
    }

    return ApiResponse::success([
        'token'=>$token,
        'usuario'=>array_merge([
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
            'cafe_id'=>$user->cafe_id
        ], $extraData)
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
