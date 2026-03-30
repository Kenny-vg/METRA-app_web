<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Resumen operativo avanzado (Tarjetas)
     */
    public function stats(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        // 1. Datos de la Vista Analítica (Capacidad y Fidelidad)
        $analitica = DB::table('vw_analitica_gerente_general')
            ->where('cafe_id', $cafeteria->id)
            ->first();

        // 2. Cálculo de Ocupación Real Hoy (Capacidad vs Comensales)
        $comensalesHoy = DB::table('reservaciones')
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', now()->toDateString())
            ->whereIn('estado', ['finalizada', 'en_curso'])
            ->sum('numero_personas');

        $capacidadTotal = $analitica ? (int)$analitica->capacidad_total : 0;
        
        // Asumiendo un promedio de 8 horas de operación para el cálculo de "Ocupación Real"
        // (Esto es una simplificación para la métrica operativa)
        $ocupacionReal = ($capacidadTotal > 0) ? round(($comensalesHoy / ($capacidadTotal)) * 100, 2) : 0;

        // 3. Tasa de No-Show (Últimos 30 días)
        $total30 = $analitica ? (int)$analitica->total_reservas_30_dias : 0;
        $noShows30 = $analitica ? (int)$analitica->no_shows_30_dias : 0;
        $noShowRate = ($total30 > 0) ? round(($noShows30 / $total30) * 100, 2) : 0;

        // 4. Fidelidad (Recurrentes vs Nuevos)
        $unicos = $analitica ? (int)$analitica->clientes_unicos : 0;
        $recurrentes = $analitica ? (int)$analitica->clientes_recurrentes : 0;
        $fidelidadRate = ($unicos > 0) ? round(($recurrentes / $unicos) * 100, 2) : 0;

        return ApiResponse::success([
            'ocupacion_real' => $ocupacionReal,
            'comensales_hoy' => (int)$comensalesHoy,
            'capacidad_total' => $capacidadTotal,
            'no_show_rate' => $noShowRate,
            'fidelidad_rate' => $fidelidadRate,
            'clientes_recurrentes' => $recurrentes,
            'clientes_nuevos' => $unicos - $recurrentes,
            'insights' => [
                'ocupacion' => $ocupacionReal > 50 ? '🔥 Alta demanda detectada' : '☕ Operación estable',
                'no_show' => $noShowRate > 15 ? '⚠️ Nivel de inasistencia elevado' : '✅ Compromiso de clientes óptimo',
                'fidelidad' => $fidelidadRate > 30 ? '🎖️ Base de clientes leales sólida' : '🚀 Gran potencial de captación'
            ]
        ]);
    }

    /**
     * Demanda por hora (Gráfico de Barras)
     */
    public function hourlyDemand(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        $data = DB::table('vw_demanda_horaria')
            ->where('cafe_id', $cafeteria->id)
            ->orderBy('hora')
            ->get();

        return ApiResponse::success($data);
    }

    /**
     * Tendencia Semanal (Gráfico de Líneas - Últimos 7 días)
     */
    public function weeklyTrends(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        $hace7Dias = now()->subDays(6)->toDateString();

        // Subconsulta en FROM para generar la serie de tiempo (evita huecos en el gráfico)
        $tendencia = DB::table('reservaciones')
            ->select('fecha', DB::raw('COUNT(*) as total'))
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', '>=', $hace7Dias)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return ApiResponse::success($tendencia);
    }
}
