<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Cafeteria;

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
            'estado'=>1 //true
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
            'estado'=>0 //false
        ]);

        return ApiResponse::success(
            $cafeteria,
            'Cafetería rechazada'
        );
    }
}
