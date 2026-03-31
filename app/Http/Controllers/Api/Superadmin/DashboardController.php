<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;

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

            // 3. Subconsulta en FROM (Inline View): Distribución de planes actuales
            // Usamos una subquery para obtener la última suscripción de cada cafetería
            // y luego agrupamos por plan sobre ese conjunto filtrado.
            'distribucion_planes' => DB::table(function ($query) {
                // Subconsulta equilibrada: Obtiene solo el último ID por cafetería
                $query->select('cafe_id', DB::raw('MAX(id) as last_id'))
                    ->from('suscripciones')
                    ->groupBy('cafe_id');
            }, 'ultimas_suscripciones')
            ->join('suscripciones as s', 's.id', '=', 'ultimas_suscripciones.last_id')
            ->join('planes as p', 'p.id', '=', 's.plan_id')
            ->select('p.nombre', DB::raw('COUNT(s.id) as total'))
            ->groupBy('p.nombre')
            ->get(),

        ], 'Dashboard superadmin cargado correctamente');
    }

}
