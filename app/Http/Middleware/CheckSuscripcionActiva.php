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
                $request->user()->currentAccessToken()?->delete();

                return ApiResponse::error(
                    'No tienes una cafetería asociada. (Debug: cafe_id=' . $user->cafe_id . ')',
                    403
                );
            }

            // Verificar suscripción activa
            $suscripcionActiva = $cafeteria->suscripciones()
                ->where('estado_pago','pagado')
                ->where('fecha_inicio','<=',now())
                ->where('fecha_fin','>=',now())
                ->first();

            if(!$suscripcionActiva){

                // cerrar sesión si expiró
                $request->user()->currentAccessToken()?->delete();

                $todasCount = $cafeteria->suscripciones()->count();
                $lastSub = $cafeteria->suscripciones()->latest('id')->first();
                $debugMsg = $lastSub ? "Estado: {$lastSub->estado_pago}, Fin: {$lastSub->fecha_fin}, Now: " . now() : "Ninguna";

                return ApiResponse::error(
                    'Tu suscripción ha expirado. (Debug: SubsCount=' . $todasCount . ' Last: ' . $debugMsg . ')',
                    403
                );
            }
        }

        return $next($request);
    }
}