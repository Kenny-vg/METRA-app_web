<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Storage;

class RenovarSuscripcionController extends Controller
{
    /**
     * El gerente solicita renovación de su suscripción:
     * - Puede hacerlo MIENTRAS su suscripción actual sigue activa.
     * - Se crea una NUEVA suscripción en estado 'pendiente'.
     * - El superadmin la revisará y la aprobará, activándola al vencer la actual.
     */
    public function store(Request $request)
    {
        $user      = $request->user();
        $cafeteria = $user->cafeteria;

        if (!$cafeteria) {
            return ApiResponse::error('No tienes una cafetería asociada.', 404);
        }

        $data = $request->validate([
            'plan_id'     => 'required|exists:planes,id',
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $plan = Plan::where('id', $data['plan_id'])->where('estado', true)->first();
        if (!$plan) {
            return ApiResponse::error('El plan seleccionado no está disponible.', 422);
        }

        // Suscripción activa actual (con pagado)
        $suscripcionActiva = $cafeteria->suscripciones()
            ->where('estado_pago', 'pagado')
            ->where('fecha_fin', '>', now())
            ->latest('fecha_fin')
            ->first();

        // Calcular fechas de la NUEVA suscripción
        $inicio = $suscripcionActiva
            ? \Carbon\Carbon::parse($suscripcionActiva->fecha_fin)->addDay()
            : now();
        $fin = $inicio->copy()->addDays($plan->duracion_dias);

        // Guardar el nuevo comprobante
        $path = $request->file('comprobante')->store('comprobantes');

        // Buscar si ya existe una renovación PENDIENTE futura (para no crear duplicados)
        $pendienteExistente = $cafeteria->suscripciones()
            ->where('estado_pago', 'pendiente')
            ->where('fecha_inicio', '>', now())   // solo registros de renovación (futuros)
            ->latest()
            ->first();

        if ($pendienteExistente) {
            // Reemplazar la solicitud anterior
            if ($pendienteExistente->comprobante_url) {
                \Storage::delete($pendienteExistente->comprobante_url);
            }
            $pendienteExistente->update([
                'plan_id'         => $plan->id,
                'fecha_inicio'    => $inicio,
                'fecha_fin'       => $fin,
                'monto'           => $plan->precio,
                'comprobante_url' => $path,
                'estado_pago'     => 'pendiente',
            ]);
            $suscripcion = $pendienteExistente;
        } else {
            $suscripcion = \App\Models\Suscripcion::create([
                'cafe_id'         => $cafeteria->id,
                'plan_id'         => $plan->id,
                'user_id'         => $user->id,
                'fecha_inicio'    => $inicio,
                'fecha_fin'       => $fin,
                'estado_pago'     => 'pendiente',
                'monto'           => $plan->precio,
                'comprobante_url' => $path,
            ]);
        }

        return ApiResponse::success([
            'suscripcion_id' => $suscripcion->id,
            'plan'           => $plan->nombre_plan,
            'fecha_inicio'   => $inicio->toDateString(),
            'fecha_fin'      => $fin->toDateString(),
        ], 'Solicitud de renovación enviada correctamente. El equipo de METRA la revisará pronto.');
    }

}
