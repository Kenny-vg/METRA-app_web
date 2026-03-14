<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\Cafeteria;
use App\Models\Mesa;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;

class ReservacionController extends Controller
{

    /**
     * Obtener horarios disponibles
     */
    public function horariosDisponibles(Request $request, $cafe_id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_personas' => 'required|integer|min:1'
        ]);

        $cafeteria = Cafeteria::findOrFail($cafe_id);

        $fecha = Carbon::parse($request->fecha);
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miercoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sabado',
            'Sunday' => 'Domingo'
        ];

        $dia = $dias[$fecha->format('l')];

        $horario = $cafeteria->horarios()
            ->where('dia_semana', $dia)
            ->first();

        if (!$horario) {
            return ApiResponse::error('La cafetería no abre ese día');
        }

        $horaInicio = Carbon::parse($horario->hora_apertura);
        $horaFin = Carbon::parse($horario->hora_cierre);

        $intervalo = $cafeteria->intervalo_reserva_min;

        $horarios = [];

        while ($horaInicio->lt($horaFin)) {

            $inicio = $horaInicio->copy();
            $fin = $inicio->copy()->addMinutes($cafeteria->duracion_reserva_min);

            if ($fin->gt($horaFin)) {
                break;
            }

            if ($this->validarDisponibilidad(
            $cafe_id,
            $request->fecha,
            $inicio,
            $fin,
            $request->numero_personas
            )) {
                $horarios[] = $inicio->format('H:i');
            }

            $horaInicio->addMinutes($intervalo);
        }

        return ApiResponse::success($horarios, 'Horarios disponibles');
    }



    /**
     * Crear reservación
     */
    public function store(Request $request)
    {
        $request->validate([
            'cafe_id' => 'required|exists:cafeterias,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'numero_personas' => 'required|integer|min:1',

            'nombre_cliente' => 'required|string|max:150',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email',

            'ocasion_especial_id' => 'nullable|exists:ocasion_especials,id',
            'promocion_id' => 'nullable|exists:promocions,id'
        ]);

        $cafeteria = Cafeteria::findOrFail($request->cafe_id);

        $horaInicio = Carbon::parse($request->hora_inicio);
        $horaFin = $horaInicio->copy()->addMinutes($cafeteria->duracion_reserva_min);

        $fechaHoraReserva = Carbon::parse($request->fecha . ' ' . $request->hora_inicio);

        if ($fechaHoraReserva->isPast()) {
            return ApiResponse::error('No se puede reservar en un horario pasado');
        }

        if (!$this->validarDisponibilidad(
        $request->cafe_id,
        $request->fecha,
        $horaInicio,
        $horaFin,
        $request->numero_personas
        )) {
            return ApiResponse::error('No hay disponibilidad en ese horario');
        }

        $folio = $this->generarFolio();

        $reservacion = Reservacion::create([
            'folio' => $folio,
            'cafe_id' => $request->cafe_id,
            'user_id' => auth()->check() ? auth()->id() : null,

            'nombre_cliente' => $request->nombre_cliente,
            'telefono' => $request->telefono,
            'email' => $request->email,

            'fecha' => $request->fecha,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'numero_personas' => $request->numero_personas,

            'comentarios' => $request->comentarios,

            'ocasion_especial_id' => $request->ocasion_especial_id,
            'promocion_id' => $request->promocion_id,

            'estado' => 'pendiente'
        ]);

        return ApiResponse::success(
            $reservacion,
            'Reservación creada correctamente'
        );
    }



    /**
     * Ver mis reservaciones
     */
    public function misReservaciones()
    {
        if (!auth()->check()) {
            return ApiResponse::error('Debe iniciar sesión', 401);
        }

        $reservas = Reservacion::where('user_id', auth()->id())
            ->latest()
            ->get();

        return ApiResponse::success($reservas, 'Reservaciones del usuario');
    }



    /**
     * Cancelar reservación
     */
    public function cancelar($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        if (auth()->check() && $reservacion->user_id !== auth()->id()) {
            return ApiResponse::error('No autorizado', 403);
        }

        if ($reservacion->estado === 'completada') {
            return ApiResponse::error('No se puede cancelar una reservación completada');
        }

        $inicio = Carbon::parse($reservacion->fecha . ' ' . $reservacion->hora_inicio);

        if ($inicio->isPast()) {
            return ApiResponse::error('La reservación ya comenzó');
        }

        $reservacion->estado = 'cancelada';
        $reservacion->save();

        return ApiResponse::success(null, 'Reservación cancelada');
    }



    /**
     * Validar disponibilidad usando MESAS
     */
    private function validarDisponibilidad($cafeId, $fecha, $inicio, $fin, $personas)
    {

        $mesas = Mesa::where('cafe_id', $cafeId)
            ->where('activo', true)
            ->get();

        $capacidadTotal = $mesas->sum('capacidad');
        $mesaMayor = $mesas->max('capacidad');

        if (!$mesaMayor) {
            return false;
        }

        if ($personas > $mesaMayor) {
            return false;
        }

        $personasReservadas = Reservacion::where('cafe_id', $cafeId)
            ->where('fecha', $fecha)
            ->where(function ($query) use ($inicio, $fin) {

            $query->where('hora_inicio', '<', $fin)
                ->where('hora_fin', '>', $inicio);

        })
            ->where('estado', '!=', 'cancelada')
            ->sum('numero_personas');


        return ($personasReservadas + $personas) <= $capacidadTotal;
    }



    /**
     * Generar folio
     */
    private function generarFolio()
    {
        return 'RSV-' . Str::upper(Str::random(6));
    }

}