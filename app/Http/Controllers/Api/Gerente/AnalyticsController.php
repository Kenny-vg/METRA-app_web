<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Reservacion;

class AnalyticsController extends Controller
{
    /**
     * Verifica si la cafetería tiene acceso a métricas avanzadas según su plan.
     */
    private function tieneMetricasAvanzadas(Request $request): bool
    {
        $plan = $request->user()->cafeteria?->plan_activo;
        return $plan && $plan->tiene_metricas_avanzadas;
    }

    /**
     * Resumen operativo avanzado (Tarjetas)
     */
    public function stats(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        $hoy = now()->toDateString();

        // 1. Datos de la Vista Analítica (Capacidad y Fidelidad Unificada)
        $analitica = DB::table('vw_analitica_gerente_general')
            ->where('cafe_id', $cafeteria->id)
            ->first();

        // 2. Reporte del día (desde vista unificada)
        $reporteHoy = DB::table('vw_reporte_diario')
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', $hoy)
            ->first();

        $reservasHoy = $reporteHoy ? (int)$reporteHoy->total_reservas : 0;
        $walkinsHoy = $reporteHoy ? (int)$reporteHoy->total_walkins : 0;
        $comensalesHoy = $reporteHoy ? (int)$reporteHoy->total_comensales_reales : 0;
        $visitasTotalesHoy = $reservasHoy + $walkinsHoy;

        $capacidadTotal = $analitica ? (int)$analitica->capacidad_total : 0;
        
        // Ocupación Real Hoy
        $ocupacionReal = ($capacidadTotal > 0) ? round(($comensalesHoy / $capacidadTotal) * 100, 2) : 0;

        // 3. Tiempo Promedio de Estancia (Hoy, en minutos)
        $tiempoPromedio = DB::table('detalle_ocupaciones')
            ->where('cafe_id', $cafeteria->id)
            ->where('estado', 'finalizada')
            ->whereNotNull('hora_salida')
            ->whereDate('hora_entrada', $hoy)
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, hora_entrada, hora_salida)) as avg_stay'))
            ->first()->avg_stay ?? 0;

        // 4. Tasa de No-Show (Últimos 30 días - Solo Reservaciones)
        $total30Reservas = DB::table('reservaciones')
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', '>=', now()->subDays(30))
            ->count();
        $noShows30 = $analitica ? (int)$analitica->no_shows_30_dias : 0;
        $noShowRate = ($total30Reservas > 0) ? round(($noShows30 / $total30Reservas) * 100, 2) : 0;

        // 5. Ratio Walk-in vs Reserva (Hoy)
        $ratioReserva = ($visitasTotalesHoy > 0) ? round(($reservasHoy / $visitasTotalesHoy) * 100, 2) : 0;
        $ratioWalkin = ($visitasTotalesHoy > 0) ? round(($walkinsHoy / $visitasTotalesHoy) * 100, 2) : 100;

        return ApiResponse::success([
            'visitas_totales' => $visitasTotalesHoy,
            'desglose' => [
                'reservaciones' => $reservasHoy,
                'walkins' => $walkinsHoy
            ],
            'comensales_hoy' => $comensalesHoy,
            'ocupacion_real_porcentaje' => $ocupacionReal,
            'tiempo_promedio_estancia_min' => round($tiempoPromedio, 0),
            'no_show_rate' => $noShowRate,
            'ratio_fuentes' => [
                'reservaciones_porcentaje' => $ratioReserva,
                'walkins_porcentaje' => $ratioWalkin
            ],
            'fidelidad' => [
                'clientes_recurrentes' => $analitica ? (int)$analitica->clientes_recurrentes : 0,
                'clientes_unicos' => $analitica ? (int)$analitica->clientes_unicos : 0
            ],
            'insights' => [
                'ocupacion' => $ocupacionReal > 70 ? '🔥 ¡Lleno total hoy!' : ($ocupacionReal > 40 ? '☕ Buena afluencia' : '🍃 Día tranquilo'),
                'fuente_principal' => $ratioWalkin > 50 ? '🚶 Mayoría de clientes directos' : '📅 Mayoría de clientes con reserva'
            ],
            // Exposición del uso mensual de reservaciones para el contador del frontend
            'suscripcion_uso' => (function() use ($cafeteria) {
                $plan = $cafeteria->plan_activo;
                if (!$plan) return null;
                $usadas = \App\Models\Reservacion::where('cafe_id', $cafeteria->id)
                    ->whereBetween('fecha', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
                    ->whereNotIn('estado', ['cancelada'])
                    ->count();
                return [
                    'plan_nombre'      => $plan->nombre_plan,
                    'reservas_usadas'  => $usadas,
                    'reservas_limite'  => $plan->max_reservas_mes,
                    'porcentaje_uso'   => $plan->max_reservas_mes > 0
                        ? round(($usadas / $plan->max_reservas_mes) * 100, 1)
                        : 0,
                    'tiene_metricas_avanzadas' => (bool) $plan->tiene_metricas_avanzadas,
                    'tiene_recordatorios'      => (bool) $plan->tiene_recordatorios,
                ];
            })()
        ]);
    }


    /**
     * Demanda por hora (Gráfico de Barras) - Solo Plan Standard/Pro
     */
    public function hourlyDemand(Request $request)
    {
        if (!$this->tieneMetricasAvanzadas($request)) {
            return ApiResponse::error(
                'Las métricas avanzadas son exclusivas del Plan Standard o Pro.',
                403,
                ['upgrade_required' => true]
            );
        }

        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        $data = DB::table('vw_demanda_horaria')
            ->where('cafe_id', $cafeteria->id)
            ->orderBy('hora')
            ->get();

        return ApiResponse::success($data);
    }

    /**
     * Tendencia Semanal (Gráfico de Líneas - Últimos 7 días) - Solo Plan Standard/Pro
     */
    public function weeklyTrends(Request $request)
    {
        if (!$this->tieneMetricasAvanzadas($request)) {
            return ApiResponse::error(
                'Las métricas avanzadas son exclusivas del Plan Standard o Pro.',
                403,
                ['upgrade_required' => true]
            );
        }

        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) return ApiResponse::error('Sin cafetería', 404);

        $hace7Dias = now()->subDays(6)->toDateString();

        // Usamos la vista de reporte diario que ya tiene los datos unificados por fecha
        $tendencia = DB::table('vw_reporte_diario')
            ->select('fecha', DB::raw('(total_reservas + total_walkins) as total'))
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', '>=', $hace7Dias)
            ->orderBy('fecha')
            ->get();

        return ApiResponse::success($tendencia);
    }

}
