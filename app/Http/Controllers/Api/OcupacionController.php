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
            $personasPorMesa = ceil($request->numero_personas / count($request->mesa_ids));

            foreach ($request->mesa_ids as $mesaId) {
                $ocupaciones[] = DetalleOcupacion::create([
                    'mesa_id' => $mesaId,
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

        //cerrar ocupacion
        $ocupacion->update([
            'estado' => DetalleOcupacion::STATUS_FINALIZADA,
            'hora_salida' => now()
        ]);

        // Actualizar reservación si existe
        $reservacion = $ocupacion->reservacion;

        if ($reservacion && $reservacion->estado === Reservacion::STATUS_ENCURSO) {
            $reservacion->update([
                'estado' => Reservacion::STATUS_FINALIZADA,
                'fecha_checkout' => now()
            ]);
        }

        //Obtener email (ocupación o reservación)
        $email = $ocupacion->email ?? $reservacion?->email;

        if ($email) {
            Mail::to($email)->send(new SolicitarResena($ocupacion));
        }

        return ApiResponse::success($ocupacion, 'Mesa cerrada');
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