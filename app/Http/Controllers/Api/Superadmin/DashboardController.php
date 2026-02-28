<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Helpers\ApiResponse;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return ApiResponse::success([
            'cafeterias_total'=>Cafeteria::count(),
            'en_revision'=>Cafeteria::where('estado','en_revision')->count(),
            'activas'=>Cafeteria::where('estado','activa')->count(),
            'suspendidas'=>Cafeteria::where('estado','suspendida')->count(),

            'planes_total'=>Plan::count(),

            'suscripciones_activas'=>
                Suscripcion::where('fecha_fin','>',now())->count(),

        ], 'Dashboard superadmin cargado correctamente');
    }
}
