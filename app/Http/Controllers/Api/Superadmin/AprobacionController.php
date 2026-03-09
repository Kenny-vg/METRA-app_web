<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Cafeteria;
use Illuminate\Support\Facades\Mail;
use App\Mail\CuentaActivadaMail;
use App\Mail\CuentaRechazadaMail;

class AprobacionController extends Controller
{
    // APROBAR CAFETERIA
    public function aprobar(Cafeteria $cafeteria)
    {
        $cafeteria->update([
            'estado'=>'activa'
        ]);

        //activar gerente
        optional($cafeteria->gerente)->update([
            'estado'=>1, //true
            'estatus_registro'=>'aprobado'
        ]);

        //marcar pago validado y resetear fechas desde hoy
        $suscripcion = $cafeteria->suscripcionActual ?? $cafeteria->suscripciones()->orderByDesc('created_at')->first();
        if ($suscripcion) {
            $plan = $suscripcion->plan;
            $duracion = $plan ? $plan->duracion_dias : 30;
            $inicio = now();
            $fin    = $inicio->copy()->addDays($duracion);

            $suscripcion->update([
                'estado_pago'      => 'pagado',
                'fecha_inicio'     => $inicio,
                'fecha_fin'        => $fin,
                'fecha_validacion' => now(),
            ]);
        }

        if ($cafeteria->gerente) {
            try {
                $loginUrl = env('FRONTEND_URL', url('/')) . '/login';

                Mail::to($cafeteria->gerente->email)
                    ->queue(new CuentaActivadaMail($loginUrl));

            } catch (\Throwable $e) {
                \Log::error("Error enviando mail: ".$e->getMessage());
            }
        }

        return ApiResponse::success(
            $cafeteria->fresh()->load([
                'gerente',
                'suscripciones.plan'
            ]),
            'Cafetería aprobada correctamente'
        );
    }

    //RECHAZAR CAFETERÍA
    public function rechazar(Cafeteria $cafeteria)
    {
        $cafeteria->update([
            'estado'=>'suspendida'
        ]);

        //desactivar gerente
        optional($cafeteria->gerente)->update([
            'estado'=>0, //false
            'estatus_registro'=>'rechazado'
        ]);

        //cancelar suscripcion
        optional($cafeteria->suscripcionActual)->update([
            'estado_pago'=>'cancelado'
        ]);

        // Notificar al gerente
        if ($cafeteria->gerente) {
            try {
                Mail::to($cafeteria->gerente->email)
                    ->queue(new CuentaRechazadaMail());
            } catch (\Throwable $e) {
                \Log::error("Error enviando mail de rechazo: ".$e->getMessage());
            }
        }

        return ApiResponse::success(
            $cafeteria,
            'Cafetería rechazada correctamente'
        );
    }
}
