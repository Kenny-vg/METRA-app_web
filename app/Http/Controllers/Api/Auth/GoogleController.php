<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;

class GoogleController extends Controller
{
    //
    public function loginGoogle(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'google_id' => 'required|string',
            'avatar' => 'nullable|string'
        ]);

        $emailAComparar = strtolower(trim($data['email']));
        $user = User::where('email', $emailAComparar)->first();

        if (!$user) {
            return ApiResponse::error(
                'Primero debes registrarte con email y contraseña',
                422
            );
        }

        $user->update([
            'google_id' => $data['google_id'],
            'avatar' => $data['avatar']
        ]);

        if (!$user->estado && $user->role === 'gerente') {

            if ($user->estatus_registro === 'rechazado') {
                return ApiResponse::error(
                    'Tu registro ha sido rechazado. Contacta a soporte.',
                    403
                );
            }

            if ($user->estatus_registro === 'pendiente') {

                $cafeteria = $user->cafeteria;

                if (!$cafeteria) {
                    return ApiResponse::error(
                        'No tienes una cafetería asociada.',
                        423
                    );
                }

                $suscripcion = $cafeteria->suscripciones()
                    ->orderByDesc('id')
                    ->first();

                if (!$suscripcion) {
                    return ApiResponse::error(
                        'Debes subir tu comprobante para continuar.',
                        423
                    );
                }

                if (empty($suscripcion->comprobante_url) && empty($cafeteria->comprobante_url)) {
                    return ApiResponse::error(
                        'Debes subir tu comprobante para continuar.',
                        423
                    );
                }

                if ($suscripcion->estado_pago === 'pendiente') {
                    return ApiResponse::error(
                        'Tu comprobante fue enviado. Espera la validación del superadmin.',
                        423
                    );
                }
            }
        }

        if (!$user->estado) {
            return ApiResponse::error('Usuario inactivo', 403);
        }

        //bloquear acceso si la cafeteria no tiene suscripción activa
        if (in_array($user->role, ['gerente', 'personal'])) {

            $cafeteria = $user->cafeteria;

            if (!$cafeteria) {
                return ApiResponse::error(
                    'No tienes una cafetería asociada.',
                    403
                );
            }

            // 1. Regla principal: Si fecha_vencimiento >= hoy, PERMITIR ACCESO
            $suscActiva = $cafeteria->suscripciones()
                ->where('fecha_fin', '>=', now()->startOfDay())
                ->first();

            if (!$suscActiva) {
                if ($user->role === 'gerente') {
                    $tienePendiente = $cafeteria->suscripciones()
                        ->where('estado_pago', 'pendiente')
                        ->exists();

                    if ($tienePendiente) {
                        return ApiResponse::error(
                            'Tu comprobante fue enviado. Espera la validación del superadmin.',
                            423
                        );
                    }

                    return ApiResponse::error(
                        'Tu cafetería no tiene una suscripción activa.',
                        423
                    );
                }

                if ($user->role === 'personal') {
                    return ApiResponse::error(
                        'La cafetería no tiene una suscripción activa.',
                        403
                    );
                }
            }
        }

        $token = $user->createToken('metra_token')->plainTextToken;

        return ApiResponse::success([
            'token' => $token,
            'usuario' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'cafe_id' => $user->cafe_id,
                'avatar' => $user->avatar
            ]
        ], 'Login con Google exitoso')->withCookie(cookie('metra_role', $user->role, 60 * 24));
    }
}
