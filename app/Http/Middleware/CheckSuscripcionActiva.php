<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class CheckSuscripcionActiva
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Solo aplicar a gerente y personal
        if ($user && in_array($user->role, ['gerente','personal'])) {

            $cafeteria = $user->cafeteria;

            if (!$cafeteria) {
                return ApiResponse::error(
                    'No tienes una cafetería asociada. (Debug: cafe_id=' . $user->cafe_id . ')',
                    403
                );
            }

            // 1. Regla principal: Si fecha_vencimiento >= hoy, PERMITIR ACCESO
            $suscripcionActiva = $cafeteria->suscripciones()
                ->where('fecha_fin','>=',now()->startOfDay())
                ->first();

            if(!$suscripcionActiva){

                // 2. Si ya expiró, verificamos si subió un comprobante pendiente de revisión
                $enRevision = $cafeteria->suscripciones()->where('en_revision', true)->exists();

                if ($enRevision) {
                    return ApiResponse::error(
                        'Tu suscripción venció, pero estamos validando tu pago. En breve tendrás acceso total.',
                        403
                    );
                }

                return ApiResponse::error(
                    'No tienes suscripción activa',
                    403
                );
            }
        }

        return $next($request);
    }
}