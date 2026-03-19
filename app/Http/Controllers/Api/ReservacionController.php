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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;

class ReservacionController extends Controller
{

    /**
     * Listar reservaciones del día (o futuras) para el gerente.
     * El CafeScope filtra automáticamente por el cafe_id del usuario autenticado.
     */
    public function index(Request $request)
    {
        $modo = $request->query('modo', 'dia');

        $query = Reservacion::with(['ocasionEspecial', 'promocion', 'zona'])
            ->where('estado', '!=', 'cancelada')
            ->orderBy('hora_inicio');

        if ($modo === 'futuras') {
            // Todas las reservaciones desde mañana en adelante
            $query->where('fecha', '>', now()->toDateString());
        }
        else {
            // Por fecha específica (default: hoy)
            $fecha = $request->query('fecha', now()->toDateString());
            $query->where('fecha', $fecha);
        }

        $reservaciones = $query->get()->map(function ($r) {
            return [
            'id' => $r->id,
            'folio' => $r->folio,
            'nombre_cliente' => $r->nombre_cliente,
            'telefono' => $r->telefono,
            'email' => $r->email,
            'fecha' => $r->fecha,
            'hora_inicio' => $r->hora_inicio,
            'hora_fin' => $r->hora_fin,
            'numero_personas' => $r->numero_personas,
            'estado' => $r->estado,
            'comentarios' => $r->comentarios,
            'ocasion' => $r->ocasionEspecial
            ? ['nombre' => $r->ocasionEspecial->nombre]
            : null,
            'promocion' => $r->promocion
            ? ['nombre' => $r->promocion->nombre_promocion, 'precio' => $r->promocion->precio]
            : null,
            'zona' => $r->zona
            ? ['nombre' => $r->zona->nombre_zona]
            : null,
            'tipo' => $r->tipo,
            ];
        });

        return ApiResponse::success($reservaciones, 'Reservaciones');
    }

    /**
     * Mostrar una reservación específica
     */
    public function show($id)
    {
        $reservacion = Reservacion::with(['cafeteria', 'ocasionEspecial', 'promocion', 'zona'])
            ->findOrFail($id);

        return ApiResponse::success($reservacion, 'Detalle de reservación');
    }

    /**
     * Obtener horarios disponibles
     */
    public function horariosDisponibles(Request $request, Cafeteria $cafeteria)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_personas' => 'required|integer|min:1'
        ]);

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
            $cafeteria->id,
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
    public function store(Request $request, Cafeteria $cafeteria)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i:s',
            'numero_personas' => 'required|integer|min:1',

            'nombre_cliente' => 'required|string|max:150',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email',

            'ocasion_especial_id' => 'nullable|exists:ocasion_especials,id',
            'promocion_id' => 'nullable|exists:promocions,id',
            'zona_id' => 'nullable|exists:zonas,id'
        ]);

        $horaInicio = Carbon::parse($request->hora_inicio);
        $horaFin = $horaInicio->copy()->addMinutes($cafeteria->duracion_reserva_min);

        $fechaHoraReserva = Carbon::parse($request->fecha . ' ' . $request->hora_inicio);

        if ($fechaHoraReserva->isPast()) {
            return ApiResponse::error('No se puede reservar en un horario pasado');
        }

        return DB::transaction(function () use ($request, $cafeteria, $horaInicio, $horaFin) {

            if (!$this->validarDisponibilidad(
            $cafeteria->id,
            $request->fecha,
            $horaInicio,
            $horaFin,
            $request->numero_personas
            )) {
                return ApiResponse::error('No hay disponibilidad en ese horario');
            }

            $duplicada = Reservacion::where('cafe_id', $cafeteria->id)
                ->where('fecha', $request->fecha)
                ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where('hora_inicio', '<', $horaFin)
                    ->where('hora_fin', '>', $horaInicio);
            }
            )
                ->where(function ($query) use ($request) {
                $query->where('telefono', $request->telefono);

                if ($request->email) {
                    $query->orWhere('email', $request->email);
                }
            }
            )
                ->where('estado', '!=', 'cancelada')
                ->exists();

            if ($duplicada) {
                return ApiResponse::error('Ya existe una reservación con esos datos en ese horario');
            }

            $folio = $this->generarFolio();

            $reservacion = Reservacion::create([
                'folio' => $folio,
                'cafe_id' => $cafeteria->id,
                'user_id' => auth('sanctum')->check() ? auth('sanctum')->id() : null,

                'nombre_cliente' => $request->nombre_cliente,
                'telefono' => $request->telefono,
                'email' => $request->email,

                'fecha' => $request->fecha,
                'hora_inicio' => $horaInicio->format('H:i:s'),
                'hora_fin' => $horaFin->format('H:i:s'),
                'numero_personas' => $request->numero_personas,

                'comentarios' => $request->comentarios ?? null,

                'ocasion_especial_id' => $request->ocasion_especial_id,
                'promocion_id' => $request->promocion_id,
                'zona_id' => $request->zona_id,

                'estado' => 'pendiente'
            ]);

            if ($reservacion->email) {
                Mail::to($reservacion->email)
                    ->send(new ReservaConfirmada($reservacion));
            }

            $reservacion->load(['cafeteria', 'ocasionEspecial', 'zona', 'promocion']);

            return ApiResponse::success(
                $reservacion,
                'Reservación creada correctamente'
            );

        });
    }



    /**
     * Ver mis reservaciones
     */
    public function misReservaciones()
    {
        if (!auth()->check()) {
            return ApiResponse::error('Debe iniciar sesión', 401);
        }

        $reservas = Reservacion::withoutGlobalScope(\App\Models\Scopes\CafeScope::class)
            ->with(['cafeteria:id,nombre', 'zona', 'promocion', 'ocasionEspecial'])
            ->where('user_id', auth()->id())
            ->latest('fecha')
            ->get()
            ->map(fn($r) => [
        'id' => $r->id,
        'folio' => $r->folio,
        'nombre_cliente' => $r->nombre_cliente,
        'fecha' => $r->fecha,
        'hora_inicio' => $r->hora_inicio,
        'hora_fin' => $r->hora_fin,
        'numero_personas' => $r->numero_personas,
        'estado' => $r->estado,
        'comentarios' => $r->comentarios,
        'cafeteria' => $r->cafeteria ? ['nombre' => $r->cafeteria->nombre] : null,
        'ocasion' => $r->ocasionEspecial ? ['nombre' => $r->ocasionEspecial->nombre] : null,
        'promocion' => $r->promocion ? ['nombre' => $r->promocion->nombre_promocion, 'precio' => $r->promocion->precio] : null,
        'zona' => $r->zona ? ['nombre' => $r->zona->nombre_zona] : null,
        ]);

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

        $capacidadTotal = Mesa::where('cafe_id', $cafeId)
            ->where('activo', true)
            ->sum('capacidad');

        $mesaMayor = Mesa::where('cafe_id', $cafeId)
            ->where('activo', true)
            ->max('capacidad');

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
     * Marcar reservación como completada
     */
    public function completar($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        $inicio = Carbon::parse($reservacion->fecha . ' ' . $reservacion->hora_inicio);

        if ($inicio->isFuture()) {
            return ApiResponse::error('La reservación aún no inicia');
        }

        if (!in_array($reservacion->estado, ['pendiente', 'confirmada'])) {
            return ApiResponse::error('Solo reservaciones pendientes o confirmadas pueden completarse');
        }

        $reservacion->estado = 'completada';
        $reservacion->save();

        $reservacion->load(['cafeteria', 'ocasionEspecial', 'zona', 'promocion']);

        return ApiResponse::success(
            $reservacion,
            'Cliente marcado como llegado'
        );
    }

    /**
     * Generar folio
     */
    private function generarFolio()
    {
        return 'RSV-' . Str::upper(Str::random(6));
    }


    /**
     * Ver detalle de una reservación por folio (público — sin auth).
     * Solo expone información no sensible.
     */
    public function showByFolio(string $folio)
    {
        // Usamos withoutGlobalScope para que no filtre por cafe_id
        $r = Reservacion::withoutGlobalScope(\App\Models\Scopes\CafeScope::class)
            ->where('folio', $folio)
            ->with(['cafeteria:id,nombre,calle,colonia,ciudad', 'zona', 'promocion', 'ocasionEspecial'])
            ->firstOrFail();

        return ApiResponse::success([
            'id' => $r->id,
            'folio' => $r->folio,
            'nombre_cliente' => $r->nombre_cliente,
            'fecha' => $r->fecha,
            'hora_inicio' => $r->hora_inicio,
            'hora_fin' => $r->hora_fin,
            'numero_personas' => $r->numero_personas,
            'estado' => $r->estado,
            'comentarios' => $r->comentarios,
            'cafeteria' => $r->cafeteria ? [
                'nombre' => $r->cafeteria->nombre,
                'calle' => $r->cafeteria->calle,
                'colonia' => $r->cafeteria->colonia,
                'ciudad' => $r->cafeteria->ciudad,
            ] : null,
            'ocasion' => $r->ocasionEspecial ? ['nombre' => $r->ocasionEspecial->nombre] : null,
            'promocion' => $r->promocion ? ['nombre' => $r->promocion->nombre_promocion, 'precio' => $r->promocion->precio] : null,
            'zona' => $r->zona ? ['nombre' => $r->zona->nombre_zona] : null,
        ]);
    }


    /**
     * Cancelar una reservación por folio (público — folio actúa como token).
     */
    public function cancelarByFolio(string $folio)
    {
        $r = Reservacion::withoutGlobalScope(\App\Models\Scopes\CafeScope::class)
            ->where('folio', $folio)
            ->firstOrFail();

        if ($r->estado === 'cancelada') {
            return ApiResponse::error('Esta reservación ya fue cancelada.', 409);
        }

        if ($r->estado === 'completada') {
            return ApiResponse::error('No se puede cancelar una reservación completada.', 409);
        }

        $inicio = Carbon::parse($r->fecha . ' ' . $r->hora_inicio);
        if ($inicio->isPast()) {
            return ApiResponse::error('No se puede cancelar una reservación cuya fecha u hora ya pasaron.', 409);
        }

        $r->update(['estado' => 'cancelada']);

        return ApiResponse::success(null, 'Reservación cancelada correctamente.');
    }

    /**
     * Cancelar una reservación por ID (gerente).
     */
    public function cancelarGerente($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        if ($reservacion->estado === 'completada') {
            return ApiResponse::error('No se puede cancelar una reservación completada');
        }

        $reservacion->estado = 'cancelada';
        $reservacion->save();

        return ApiResponse::success(
            null,
            'Reservación cancelada por el gerente'
        );
    }

}