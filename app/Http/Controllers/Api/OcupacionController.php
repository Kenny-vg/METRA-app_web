<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetalleOcupacion;
use App\Models\Mesa;
use App\Models\Reservacion;
use App\Helpers\ApiResponse;
use App\Mail\SolicitarResena;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OcupacionController extends Controller
{

    /**
     * Ver mesas ocupadas
     */
    public function index()
    {
        $ocupaciones = DetalleOcupacion::with('mesa')
            ->where('estado', DetalleOcupacion::STATUS_ACTIVA)
            ->get();

        return ApiResponse::success($ocupaciones, 'Mesas ocupadas');
    }


    /**
     * Abrir mesa (sentar cliente walk-in)
     */
    public function store(Request $request)
    {

        $request->validate([
            'mesa_ids' => 'required|array|min:1',
            'mesa_ids.*' => 'exists:mesas,id',
            'zona_id' => 'required|exists:zonas,id',
            'numero_personas' => 'required|integer|min:1',
            'reservacion_id' => 'nullable|exists:reservaciones,id',
            'nombre_cliente' => 'nullable|string|max:150',
            'email' => 'nullable|email',
            'comentarios' => 'nullable|string|max:255'
        ]);

        return DB::transaction(function () use ($request) {
            $reservacion = null;

            if ($request->reservacion_id) {
                $reservacion = Reservacion::find($request->reservacion_id);

                if (!$reservacion || !in_array($reservacion->estado, [Reservacion::STATUS_PENDIENTE, Reservacion::STATUS_ENCURSO])) {
                    return ApiResponse::error('La reservación no está disponible para ocupar');
                }

                $yaOcupada = DetalleOcupacion::where('reservacion_id', $request->reservacion_id)
                    ->where('estado', DetalleOcupacion::STATUS_ACTIVA)
                    ->exists();

                if ($yaOcupada) {
                    return ApiResponse::error('Esta reservación ya está en uso');
                }

                // VALIDACIÓN DE FECHA (Timezone configurado: America/Mexico_City)
                if (!$reservacion->esParaHoy()) {
                    return ApiResponse::error('Esta reservación no corresponde al día de hoy. Por favor, selecciona una reservación válida para la fecha actual o marca la llegada como Walk-in.', 422);
                }
            }

            // Bloquear filas de las mesas para evitar condiciones de carrera
            $mesas = Mesa::whereIn('id', $request->mesa_ids)
                ->lockForUpdate()
                ->get();

            // Validar capacidad total
            $capacidadTotalMesas = $mesas->sum('capacidad');

            if ($request->numero_personas > $capacidadTotalMesas) {
                return ApiResponse::error('Las mesas no tienen capacidad suficiente');
            }

            // Validar que no estén ocupadas (físicamente o por estado activa)
            $mesasOcupadas = DetalleOcupacion::whereIn('mesa_id', $request->mesa_ids)
                ->where('estado', DetalleOcupacion::STATUS_ACTIVA)
                ->exists();

            if ($mesasOcupadas) {
                return ApiResponse::error('Una o más mesas ya están ocupadas');
            }

            $ocupaciones = [];
            $grupoId = (string) Str::uuid();
            $personasPorMesa = ceil($request->numero_personas / count($request->mesa_ids));

            foreach ($request->mesa_ids as $mesaId) {
                $ocupaciones[] = DetalleOcupacion::create([
                    'mesa_id' => $mesaId,
                    'grupo_id' => $grupoId,
                    'numero_personas' => $personasPorMesa,

                    'reservacion_id' => $request->reservacion_id,
                    'tipo' => $request->reservacion_id ? 'reservacion' : 'walkin',
                    'nombre_cliente' => $request->nombre_cliente ?? ($reservacion ? $reservacion->nombre_cliente : null),
                    'email' => $request->email ?? ($reservacion ? $reservacion->email : null),
                    'comentarios' => $request->comentarios,
                    'hora_entrada' => now(),
                    'estado' => DetalleOcupacion::STATUS_ACTIVA,
                    'token_resena' => ($request->email || ($reservacion && $reservacion->email)) ? Str::random(40) : null,
                    'cafe_id' => auth()->user()->cafe_id,
                    'user_id' => auth()->id()
                ]);
            }

            // Actualizar reservación si existe
            if ($reservacion) {
                $reservacion->update([
                    'estado' => Reservacion::STATUS_ENCURSO,
                    'fecha_checkin' => now()
                ]);
            }

            return ApiResponse::success($ocupaciones, 'Mesas abiertas');
        });
    }

    /**
     * Cerrar mesa (cliente se va/paga)
     */
    public function finalizar($id)
    {
        $ocupacion = DetalleOcupacion::findOrFail($id);

        if ($ocupacion->estado !== DetalleOcupacion::STATUS_ACTIVA) {
            return ApiResponse::error('La mesa ya está cerrada');
        }

        $grupoId = $ocupacion->grupo_id;
        $reservacionId = $ocupacion->reservacion_id;

        // Buscamos todas las ocupaciones activas asociadas al mismo grupo o reservación
        $ocupacionesRelacionadasQuery = DetalleOcupacion::where('estado', DetalleOcupacion::STATUS_ACTIVA);

        if ($grupoId) {
            $ocupacionesRelacionadasQuery->where('grupo_id', $grupoId);
        } elseif ($reservacionId) {
            $ocupacionesRelacionadasQuery->where('reservacion_id', $reservacionId);
        } else {
            $ocupacionesRelacionadasQuery->where('id', $id);
        }

        $ocupacionesAFinalizar = $ocupacionesRelacionadasQuery->get();

        return DB::transaction(function () use ($ocupacionesAFinalizar, $ocupacion) {
            $ahora = now();

            // Actualizamos todas las ocupaciones del grupo en una sola consulta
            DetalleOcupacion::whereIn('id', $ocupacionesAFinalizar->pluck('id'))
                ->update([
                    'estado' => DetalleOcupacion::STATUS_FINALIZADA,
                    'hora_salida' => $ahora
                ]);

            // Actualizar reservación si existe
            $reservacion = $ocupacion->reservacion;

            if ($reservacion && $reservacion->estado === Reservacion::STATUS_ENCURSO) {
                $reservacion->update([
                    'estado' => Reservacion::STATUS_FINALIZADA,
                    'fecha_checkout' => $ahora
                ]);
            }

            // Obtener email (del registro principal o de la reservación)
            $email = $ocupacion->email ?? $reservacion?->email;

            if ($email) {
                // Solo se envía una vez para todo el grupo literal gracias a que cerramos el grupo en esta misma petición
                Mail::to($email)->send(new SolicitarResena($ocupacion));
            }

            return ApiResponse::success($ocupacion, count($ocupacionesAFinalizar) . ' mesa(s) liberada(s) correctamente.');
        });
    }


    public function estadoMesas()
    {
        $mesas = Mesa::with('zona')->get()->map(function ($mesa) {
            return [
                'id' => $mesa->id,
                'numero' => $mesa->numero_mesa,
                'capacidad' => $mesa->capacidad,
                'zona' => $mesa->zona->nombre_zona,
                'estado' => $mesa->esta_ocupada ? 'ocupada' : 'libre'
            ];
        });

        return ApiResponse::success($mesas, 'Estado de mesas');
    }
}