<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafeteria;
use App\Helpers\ApiResponse;

class SolicitudesController extends Controller
{
    //
    public function index()
    {
        $data = Cafeteria::with([
            'gerente',
            'suscripcionActual.plan'
        ])
        ->where('estado','en_revision') 
        ->get();

        return ApiResponse::success(
            $data, 
            'Solicitudes cargadas correctamente'
        );
    }
}
