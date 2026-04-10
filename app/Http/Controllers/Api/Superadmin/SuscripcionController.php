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
            // HISTORIAL MODE: Devolver todas las suscripciones de esta cafetería
            $historial = Suscripcion::with(['cafeteria', 'plan'])
                ->where('cafe_id', $request->cafe_id)
                ->orderBy('fecha_inicio', 'desc')
                ->get()
                ->map(function($s) {
                    return [
                        'id' => $s->id,
                        'tipo' => 'historial', // Frontend podria esperar esta propiedad
                        'plan' => $s->plan,
                        'monto' => $s->monto,
                        'fecha_inicio' => $s->fecha_inicio,
                        'fecha_fin' => $s->fecha_fin,
                        'estado_pago' => $s->estado_pago,
                        'comprobante_url' => $s->comprobante_url,
                    ];
                });

            return ApiResponse::success(
                $historial,
                'Historial completo'
            );
        }

        // Modo Normal (Dashboard Principal)
        // Por cada cafetería, mostrar la suscripción más relevante con esta prioridad:
        // 1) pendiente (en_revision) → gerente acaba de enviar comprobante
        // 2) pagado vigente          → suscripción activa normal
        // 3) pagado vencido          → expirada pero fue pagada
        // 4) cualquier otra          → la más reciente por id
        $todas = $query->orderBy('id', 'desc')->get();

        $prioridad = function (Suscripcion $s): int {
            if ($s->estado_pago === 'pendiente' || $s->en_revision) return 0;
            if ($s->estado_pago === 'pagado' && $s->fecha_fin && \Carbon\Carbon::parse($s->fecha_fin)->isFuture()) return 1;
            if ($s->estado_pago === 'pagado') return 2;
            return 3;
        };

        $ultimas = $todas
            ->groupBy('cafe_id')
            ->map(fn($grupo) => $grupo->sortBy(fn($s) => $prioridad($s))->first())
            ->values();

        return ApiResponse::success(
            $ultimas,
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
        // Caso 1: Comprobante en Cloudinary (autenticado)
        if ($suscripcion->comprobante_public_id) {
            try {
                $cloudinary = app(\App\Services\CloudinaryService::class);
                try {
                    $signedUrl = $cloudinary->privateDownloadUrl($suscripcion->comprobante_public_id, 'jpg', 'image');
                } catch (\Throwable $e) {
                    $signedUrl = $cloudinary->privateDownloadUrl($suscripcion->comprobante_public_id, 'pdf', 'raw');
                }
                return redirect()->away($signedUrl);
            } catch (\Throwable $e) {
                \Log::error("Error generando URL firmada suscripción: " . $e->getMessage());
                return ApiResponse::error('Error al generar acceso al comprobante', 500);
            }
        }

        // Caso 2: Legacy en storage local
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

        // Si la fecha de inicio es hoy o pasada, recalcular desde hoy para que no pierda días.
        // Si es futura, mantenerlas (renovación normal encadenada).
        if (\Carbon\Carbon::parse($suscripcion->fecha_inicio)->startOfDay()->isFuture()) {
            $nueva_fecha_inicio = $suscripcion->fecha_inicio;
            $nueva_fecha_fin    = $suscripcion->fecha_fin;
        } else {
            $nueva_fecha_inicio = now()->startOfDay();
            $nueva_fecha_fin    = now()->startOfDay()->addDays(max(0, $plan_aprobar->duracion_dias - 1))->endOfDay();
        }

        // Si es un UPGRADE (plan diferente), cancelar las suscripciones previas activas
        // para que no queden planes solapados para la misma cafetería.
        $esCambioDePlan = Suscripcion::where('cafe_id', $cafeteria->id)
            ->where('id', '!=', $suscripcion->id)
            ->where('estado_pago', 'pagado')
            ->where('fecha_fin', '>', now())
            ->exists();

        if ($esCambioDePlan) {
            Suscripcion::where('cafe_id', $cafeteria->id)
                ->where('id', '!=', $suscripcion->id)
                ->where('estado_pago', 'pagado')
                ->where('fecha_fin', '>', now())
                ->update([
                    'estado_pago' => 'cancelado',
                    'fecha_fin'   => now()->subSecond(), // Termina justo antes de hoy
                ]);
        }

        $suscripcion->update([
            'plan_id'            => $plan_aprobar->id,
            'plan_solicitado_id' => null,
            'fecha_inicio'       => $nueva_fecha_inicio,
            'fecha_fin'          => $nueva_fecha_fin,
            'estado_pago'        => 'pagado',
            'monto'              => $plan_aprobar->precio,
            'fecha_validacion'   => now(),
            'en_revision'        => false,
        ]);

        // Asegurarnos de que el estado de la cafetería refleje que está activa
        $cafeteria->update(['estado' => 'activa']);

        return ApiResponse::success(
            $suscripcion->fresh()->load(['cafeteria', 'plan']),
            '¡Aprobado! La suscripción al Plan ' . $plan_aprobar->nombre_plan .
                ' estará activa hasta el ' .
                \Carbon\Carbon::parse($nueva_fecha_fin)->format('d/m/Y') . '.'
        );
    }

    /**
     * Rechazar renovación de suscripción pendiente.
     * Marca como cancelado y pone comprobante_url='RECHAZADO' como flag
     * para que el gerente sepa que puede volver a intentarlo.
     */
    public function rechazarRenovacion(Suscripcion $suscripcion)
    {
        if (!$suscripcion->en_revision) {
            return ApiResponse::error('Esta suscripción no está pendiente de aprobación.', 422);
        }

        $suscripcion->update([
            'estado_pago'      => 'cancelado',
            'en_revision'      => false,
            'fecha_validacion' => now(),
            'comprobante_url'  => 'RECHAZADO',
        ]);

        // Enviar email de notificación al gerente
        try {
            $gerente = $suscripcion->cafeteria?->gerente;
            if ($gerente && $gerente->email) {
                \Illuminate\Support\Facades\Mail::to($gerente->email)
                    ->send(new \App\Mail\ComprobanteRechazado(
                        $suscripcion->cafeteria->nombre ?? 'tu cafetería'
                    ));
            }
        } catch (\Throwable $e) {
            \Log::warning('No se pudo enviar email de rechazo: ' . $e->getMessage());
        }

        return ApiResponse::success(
            null,
            'Comprobante rechazado. El gerente podrá volver a enviar su solicitud.'
        );
    }
}
