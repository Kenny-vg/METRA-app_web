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
            $query->where('cafe_id', $request->cafe_id)
                ->orderBy('fecha_fin', 'desc');
        }

        return ApiResponse::success(
            $query->get(),
            'Listado de Suscripciones'
        );
    }

    /**
     * CREAR SUSCRIPCION.
     */
    public function store(Request $request)    {
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
            ->addDays($plan->duracion_dias)->endOfDay();

        $suscripcion = Suscripcion::create([
            'cafe_id' => $data['cafe_id'],
            'plan_id' => $data['plan_id'],
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado_pago' => 'pendiente',
            'monto' => $plan->precio,
        ]);

        $suscripcion->load(['cafeteria', 'plan']);

        return ApiResponse::success(
            $suscripcion,
            'Suscripción creada correctamente'
        );    }

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
     * Aprobar renovación de suscripción — para cafeterías activas que renovaron.
     * Marca la suscripción pendiente como 'pagado'.
     */
    public function aprobarRenovacion(Suscripcion $suscripcion)
    {
        if ($suscripcion->estado_pago !== 'pendiente') {
            return ApiResponse::error('Esta suscripción no está pendiente de aprobación.', 422);
        }

        $cafeteria = $suscripcion->cafeteria;

        if (!$cafeteria || $cafeteria->estado === 'suspendida') {
            return ApiResponse::error('La cafetería asociada está suspendida o no existe.', 422);
        }

        $suscripcion->update([
            'estado_pago'      => 'pagado',
            'fecha_validacion' => now(),
        ]);

        return ApiResponse::success(
            $suscripcion->fresh()->load(['cafeteria', 'plan']),
            '¡Renovación aprobada! La suscripción estará activa a partir de ' .
                \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') . '.'
        );
    }
}
