<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Cafeteria;
use Illuminate\Support\Facades\Mail;
use App\Mail\CuentaActivadaMail;

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
            'estado'=>1 //true
        ]);

        //marcar pago validado
        optional($cafeteria->suscripcionActual)->update([
            'estado_pago'=>'pagado',
            'fecha_validacion'=>now(),
        ]);

        if ($cafeteria->gerente) {
            Mail::to($cafeteria->gerente->email)
                ->send(new CuentaActivadaMail());
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
            'estado'=>0 //false
        ]);

        //cancelar suscripcion
        optional($cafeteria->suscripcionActual)->update([
            'estado_pago'=>'cancelado'
        ]);

        return ApiResponse::success(
            $cafeteria,
            'Cafetería rechazada correctamente'
        );
    }
}
