<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class AprobacionController extends Controller
{
    //
    public function aprobar(Cafeteria $cafeteria)
    {
        $cafeteria->update([
            'estado'=>'activa'
        ]);

        //activar gerente
        optional($cafeteria->gerente)->update([
            'estado'=>'true'
        ]);

        //marcar pago
        optional($cafeteria->suscripcionActual)->update([
            'estado_pago'=>'pagado',
            'fecha_validacion'=>now(),
        ]);

        return ApiResponse::success(
            $cafeteria,
            'Cafetería aprobada correctamente'
        );
    }

    public function rechazar(Cafeteria $cafeteria)
    {
        $cafeteria->update([
            'estado'=>false
        ]);

        return ApiResponse::success(
            $cafeteria,
            'Cafetería rechazada'
        );
    }
}
