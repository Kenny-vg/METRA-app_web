<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Models\Cafeteria;
use App\Helpers\ApiResponse;
use Carbon\Carbon;



class SuscripcionController extends Controller
{
    /**
     * LISTA DE SUSCRIPCIONES.
     */
    public function index(Request $request)
    {
        $query = Suscripcion::with(['cafeteria', 'plan']);

        if ($request->has('cafe_id')) {
            // HISTORIAL MODE: Devolver tanto la actual como las históricas
            
            // 1. Suscripciones actuales
            $actuales = Suscripcion::with(['cafeteria', 'plan'])
                ->where('cafe_id', $request->cafe_id)
                ->get()
                ->map(function($s) {
                    return [
                        'id' => $s->id,
                        'tipo' => 'actual',
                        'plan' => $s->plan,
                        'monto' => $s->monto,
                        'fecha_inicio' => $s->fecha_inicio,
                        'fecha_fin' => $s->fecha_fin,
                        'estado_pago' => $s->estado_pago,
                        'comprobante_url' => $s->comprobante_url,
                    ];
                });

            // 2. Históricas
            $historial = \App\Models\RenovacionHistorial::with('plan')
                ->where('cafe_id', $request->cafe_id)
                ->get()
                ->map(function($h) {
                    return [
                        'id' => $h->id,
                        'tipo' => 'historial',
                        'plan' => $h->plan,
                        'monto' => $h->monto,
                        'fecha_inicio' => $h->fecha_inicio_anterior,
                        'fecha_fin' => $h->fecha_fin_anterior,
                        'estado_pago' => $h->estado_pago_anterior,
                        'comprobante_url' => $h->comprobante_url,
                    ];
                });

            // 3. Juntar y ordenar por fecha_inicio descendente
            $completo = $actuales->concat($historial)->sortByDesc('fecha_inicio')->values();

            return ApiResponse::success(
                $completo,
                'Historial completo'
            );
        }

        // Modo Normal (Dashboard Principal)
        return ApiResponse::success(
            $query->get(),
            'Listado de Suscripciones'
        );
    }

    /**
     * SUSCRIPCIONES PENDIENTES DE REVISIÓN.
     * Retorna solo las suscripciones marcadas con en_revision=true.
     * Se usa para mostrar la sección de alertas en el dashboard del Superadmin.
     */
    public function pendientes()
    {
        $pendientes = Suscripcion::with(['cafeteria', 'plan'])
            ->where('en_revision', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return ApiResponse::success($pendientes, 'Solicitudes pendientes de revisión');
    }

    /**
     * CREAR SUSCRIPCION.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cafe_id' => 'required|exists:cafeterias,id',
            'plan_id' => 'required|exists:planes,id',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        if (!$plan->estado) {
            return ApiResponse::error(
                'El plan seleccionado ya no está activo',
                400
            );
        }

        $activa = Suscripcion::where('cafe_id', $data['cafe_id'])
            ->where('fecha_fin', '>', now())
            ->latest('fecha_fin')
            ->first();

        $futura = Suscripcion::where('cafe_id', $data['cafe_id'])
            ->where('fecha_inicio', '>', now())
            ->exists();

        if ($futura) {
            return ApiResponse::error(
                'Ya existe una renovación pendiente',
                400
            );
        }

        $fecha_inicio = $activa
            ? Carbon::parse($activa->fecha_fin)->startOfDay()->addDay()
            : now()->startOfDay();

        $fecha_fin = (clone $fecha_inicio)
            ->addDays(max(0, $plan->duracion_dias - 1))->endOfDay();

        $suscripcion = Suscripcion::create([
            'cafe_id'      => $data['cafe_id'],
            'plan_id'      => $data['plan_id'],
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin'    => $fecha_fin,
            'estado_pago'  => 'pendiente',
            'monto'        => $plan->precio,
            'en_revision'  => false,
        ]);

        $suscripcion->load(['cafeteria', 'plan']);

        return ApiResponse::success(
            $suscripcion,
            'Suscripción creada correctamente'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Suscripcion $suscripcion)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suscripcion $suscripcion)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suscripcion $suscripcion)
    {
    //
    }

    /**
     * Servir el comprobante de una suscripción.
     */
    public function verComprobante(Suscripcion $suscripcion)
    {
        if (!$suscripcion->comprobante_url) {
            return ApiResponse::error('Esta suscripción no tiene comprobante.', 404);
        }

        if (!\Illuminate\Support\Facades\Storage::exists($suscripcion->comprobante_url)) {
            return ApiResponse::error('Archivo no encontrado.', 404);
        }

        return response()->file(
            \Illuminate\Support\Facades\Storage::path($suscripcion->comprobante_url)
        );
    }

    /**
     * Servir el comprobante de una suscripción antigua (en historial).
     */
    public function verComprobanteHistorial($id)
    {
        $historial = \App\Models\RenovacionHistorial::findOrFail($id);

        if (!$historial->comprobante_url) {
            return ApiResponse::error('Esta suscripción antigua no tiene comprobante.', 404);
        }

        if (!\Illuminate\Support\Facades\Storage::exists($historial->comprobante_url)) {
            return ApiResponse::error('Archivo no encontrado.', 404);
        }

        return response()->file(
            \Illuminate\Support\Facades\Storage::path($historial->comprobante_url)
        );
    }

    /**
     * Aprobar renovación de suscripción — para cafeterías activas que renovaron.
     * Calcula las nuevas fechas, marca como pagado y sincroniza la cafetería.
     */
    public function aprobarRenovacion(Suscripcion $suscripcion)
    {
        if (!$suscripcion->en_revision) {
            return ApiResponse::error('Esta suscripción no está pendiente de aprobación (en_revision es false).', 422);
        }

        $cafeteria = $suscripcion->cafeteria;

        if (!$cafeteria || $cafeteria->estado === 'suspendida') {
            return ApiResponse::error('La cafetería asociada está suspendida o no existe.', 422);
        }

        $plan_aprobar = $suscripcion->plan_solicitado_id 
            ? \App\Models\Plan::find($suscripcion->plan_solicitado_id) 
            : $suscripcion->plan;

        // REGLA DE ORO: Si renueva antes de vencer, sumar días. Si renueva vencido, empezar desde hoy.
        if (\Carbon\Carbon::parse($suscripcion->fecha_fin)->isFuture()) {
            // Aún tenía días, sumarle los días del plan a partir de su fecha final actual
            $nueva_fecha_inicio = $suscripcion->fecha_inicio; // se queda igual
            $nueva_fecha_fin = \Carbon\Carbon::parse($suscripcion->fecha_fin)
                ->addDays(max(0, $plan_aprobar->duracion_dias)); // Se extiende
        } else {
            // Ya venció, empieza la suscripción a contar desde HOY
            $nueva_fecha_inicio = now()->startOfDay();
            $nueva_fecha_fin = now()->startOfDay()->addDays(max(0, $plan_aprobar->duracion_dias - 1))->endOfDay();
        }

        $suscripcion->update([
            'plan_id'            => $plan_aprobar->id,
            'plan_solicitado_id' => null,
            'fecha_inicio'       => $nueva_fecha_inicio,
            'fecha_fin'          => $nueva_fecha_fin,
            'estado_pago'        => 'pagado',
            'monto'              => $plan_aprobar->precio,
            'fecha_validacion'   => now(),
            'en_revision'        => false, // Limpiar flag de revisión
        ]);

        // Asegurarnos de que el estado de la cafetería refleje que ya no está vencida/pendiente
        $cafeteria->update([
            'estado' => 'activa'
        ]);

        return ApiResponse::success(
            $suscripcion->fresh()->load(['cafeteria', 'plan']),
            '¡Renovación aprobada! La suscripción estará activa hasta el ' .
                \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('d/m/Y') . '.'
        );
    }
}
