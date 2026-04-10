<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\DB;

class CafeteriaPerfilController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * ACCIONES DEL GERENTE
     */

    //Ver mi cafetería
    public function show(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;

        if ($cafeteria) {
            $cafeteria->load(['suscripcionActual.plan', 'gerente']);
            
            // Calculo de uso mensual de reservaciones (Suscripción Tiered)
            $inicioMes = now()->startOfMonth()->toDateString();
            $finMes    = now()->endOfMonth()->toDateString();
            
            $cafeteria->reservas_mes_actual = \App\Models\Reservacion::where('cafe_id', $cafeteria->id)
                ->whereBetween('fecha', [$inicioMes, $finMes])
                ->whereNotIn('estado', [\App\Models\Reservacion::STATUS_CANCELADA])
                ->count();

            // Calculo dinámico de capacidad total (suma capacidad de todas las mesas activas)
            $cafeteria->capacidad_total = \App\Models\Mesa::where('cafe_id', $cafeteria->id)
                ->where('activo', 1)
                ->sum('capacidad');
        }

        return ApiResponse::success(
            $cafeteria,
            'Perfil cafetería'
        );
    }



    //Actualizar mi cafetería
    public function update(Request $request)
    {
        $camposTexto = ['nombre', 'descripcion', 'calle', 'num_exterior', 'num_interior', 'colonia', 'estado_republica', 'ciudad'];
        foreach ($camposTexto as $campo) {
            if ($request->has($campo) && !empty($request->$campo)) {
                $request->merge([$campo => strip_tags($request->$campo)]);
            }
        }

        $cafeteria = $request->user()->cafeteria;

        //seguridad
        if (!$cafeteria) {
            return ApiResponse::error(
                'El usuario no tiene cafetería asignada',
                404
            );
        }

        // Limpiar el teléfono antes de validar si existe en el request
        if ($request->has('telefono') && !empty($request->telefono)) {
            $request->merge([
                'telefono' => preg_replace('/[^0-9]/', '', $request->telefono)
            ]);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'calle' => 'sometimes|required|string|max:100',
            'num_exterior' => 'nullable|string|max:10',
            'num_interior' => 'nullable|string|max:10',
            'colonia' => 'sometimes|required|string|max:50',
            'estado_republica' => 'nullable|string|max:80',
            'ciudad' => 'nullable|string|max:80',
            'cp' => 'nullable|digits:5',
            'telefono' => 'nullable|digits:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'porcentaje_reservas' => 'sometimes|integer|min:0|max:100',
            'duracion_reserva_min' => 'sometimes|integer|min:15|max:240',
            'intervalo_reserva_min' => 'sometimes|integer|min:15|max:120',
            'tolerancia_reserva_min' => 'sometimes|integer|min:5|max:60',
        ]);

        if ($request->hasFile('foto')) {
            try {
                // Borrar anterior de Cloudinary si existe
                if ($cafeteria->foto_public_id) {
                    $this->cloudinary->delete($cafeteria->foto_public_id);
                }

                // Subir nueva foto a Cloudinary (pública)
                $result = $this->cloudinary->upload($request->file('foto'), 'metra/perfiles');
                $data['foto_url'] = $result['url'];
                $data['foto_public_id'] = $result['public_id'];
            } catch (\Throwable $e) {
                \Log::error("Error Cloudinary upload perfil: " . $e->getMessage());
                return ApiResponse::error('Error al subir la foto a Cloudinary', 500);
            }
        }

        // Limpieza final: remover 'foto' antes del update ya que en DB es 'foto_url'
        unset($data['foto']);
        
        $cafeteria->update($data);

        $cafeteria->refresh(); //Devuelve los datos actualizados

        return ApiResponse::success(
            $cafeteria,
            'Cafetería actualizada correctamente'
        );
    }

    // Endpoint analítico api-first de Vistas
    public function metricasDiarias(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) {
            return ApiResponse::success(new \stdClass(), 'Métricas vacías, el gerente no tiene cafetería');
        }

        // Lee directo la VISTA NATIVA
        $metricas = DB::table('vw_reporte_diario')
            ->where('cafe_id', $cafeteria->id)
            ->where('fecha', now()->toDateString())
            ->first();

        // Estructura base
        $data = [
            'cafe_id' => $cafeteria->id,
            'fecha' => now()->toDateString(),
            'total_reservas' => $metricas ? (int)$metricas->total_reservas : 0,
            'reservas_completadas' => $metricas ? (int)$metricas->reservas_completadas : 0,
            'reservas_canceladas' => $metricas ? (int)$metricas->reservas_canceladas : 0,
            'no_shows' => $metricas ? (int)$metricas->no_shows : 0,
            'total_comensales_esperados' => $metricas ? (int)$metricas->total_comensales_esperados : 0
        ];

        // LÓGICA DE NEGOCIO Y DERIVADOS (API-FIRST)
        $totales = $data['total_reservas'];
        $bajas = $data['reservas_canceladas'] + $data['no_shows'];
        
        $data['porcentaje_ocupacion'] = $totales > 0 ? round(($data['reservas_completadas'] / $totales) * 100, 2) : 0;
        $data['porcentaje_cancelacion'] = $totales > 0 ? round(($bajas / $totales) * 100, 2) : 0;

        // INSIGHTS UX
        if ($data['porcentaje_ocupacion'] >= 70) {
            $data['insight_ocupacion'] = '🔥 Excelente afluencia';
        } elseif ($data['porcentaje_ocupacion'] <= 30 && $totales > 0) {
            $data['insight_ocupacion'] = '📉 Baja ocupación esperada';
        } else {
            $data['insight_ocupacion'] = '☕ Operación estable';
        }

        if ($data['porcentaje_cancelacion'] >= 20) {
            $data['insight_cancelacion'] = '⚠️ Nivel crítico de bajas';
        } else {
            $data['insight_cancelacion'] = '✅ Retención estable';
        }

        return ApiResponse::success($data, 'Métricas diarias de MySQL con Insights');
    }

    // Endpoint analítico api-first (MENSUALES - Vista Materializada)
    public function metricasMensuales(Request $request)
    {
        $cafeteria = $request->user()->cafeteria;
        if (!$cafeteria) {
            return ApiResponse::success([], 'Sin datos, el gerente no tiene cafetería');
        }

        $metricas = DB::table('mv_metricas_mensuales')
            ->where('cafe_id', $cafeteria->id)
            ->orderByDesc('anio')
            ->orderByDesc('mes')
            ->take(12)
            ->get();

        return ApiResponse::success($metricas, 'Métricas mensuales Materializadas');
    }

}
