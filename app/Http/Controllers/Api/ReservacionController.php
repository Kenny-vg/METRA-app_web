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
use App\Mail\ReservaCancelada;
use App\Mail\ReservaNoShow;

class ReservacionController extends Controller
{

    /**
     * Listar reservaciones por rango de fechas para el gerente (y la app móvil).
     * El CafeScope filtra automáticamente por el cafe_id del usuario autenticado.
     *
     * Query params:
     *   desde    (date, default: hoy)          — fecha inicio del rango
     *   hasta    (date, default: desde + 30d)  — fecha fin del rango
     *   per_page (int,  opcional)              — activa paginación
     */
    public function index(Request $request)
    {
        $desde = $request->query('desde', now()->toDateString());
        $hasta = $request->query('hasta', Carbon::parse($desde)->addDays(30)->toDateString());

        $query = Reservacion::with(['ocasionEspecial', 'promocion', 'zona'])
            ->select(
                'reservaciones.*',
                'detalle_ocupaciones.mesa_asignada_fisicamente'
            )
            ->leftJoinSub(
                DB::table('detalle_ocupaciones')
                    ->select('reservacion_id', DB::raw('count(*) as mesa_asignada_fisicamente'))
                    ->groupBy('reservacion_id'),
                'detalle_ocupaciones',
                'detalle_ocupaciones.reservacion_id',
                '=',
                'reservaciones.id'
            )
            ->whereBetween('reservaciones.fecha', [$desde, $hasta])
            ->orderBy('reservaciones.fecha')
            ->orderBy('reservaciones.hora_inicio');

        if ($request->filled('per_page')) {
            $reservaciones = $query->paginate((int) $request->query('per_page'))
                ->through(fn ($r) => $this->formatReservacion($r));
            return ApiResponse::success($reservaciones, 'Reservaciones');
        }

        $reservaciones = $query->get()->map(fn ($r) => $this->formatReservacion($r));

        return ApiResponse::success($reservaciones, 'Reservaciones');
    }

    /**
     * Mostrar una reservación específica
     */
    public function show($id)
    {
        $reservacion = Reservacion::with(['cafeteria', 'ocasionEspecial', 'promocion', 'zona'])
            ->findOrFail($id);

        return ApiResponse::success($this->formatReservacion($reservacion), 'Detalle de reservación');
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
                ->whereIn('estado', [Reservacion::STATUS_PENDIENTE, Reservacion::STATUS_ENCURSO])
                ->exists();

            if ($duplicada) {
                return ApiResponse::error('Ya existe una reservación con esos datos en ese horario');
            }

            $folio = $this->generarFolio();

            // Vincular automáticamente por UserID si el cliente está autenticado
            // O si existe un usuario registrado con ese correo (back-link)
            $userId = auth('sanctum')->check() ? auth('sanctum')->id() : null;
            if (!$userId && $request->email) {
                $userMatch = \App\Models\User::where('email', $request->email)->where('role', 'cliente')->first();
                if ($userMatch) $userId = $userMatch->id;
            }

            $reservacion = Reservacion::create([
                'folio' => $folio,
                'cafe_id' => $cafeteria->id,
                'user_id' => $userId,

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

                'estado' => Reservacion::STATUS_PENDIENTE
            ]);

            try {
                if ($reservacion->email) {
                    Mail::to($reservacion->email)
                        ->send(new ReservaConfirmada($reservacion));
                }
            }
            catch (\Exception $e) {
                // Previene rollback si el servidor SMTP falla
                \Illuminate\Support\Facades\Log::error('SMTP/Email Error en reservación: ' . $e->getMessage());
            }

            $reservacion->load(['cafeteria', 'ocasionEspecial', 'zona', 'promocion']);

            return ApiResponse::success(
                $this->formatReservacion($reservacion),
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

        $user = auth()->user();

        // Sin restringir a 'activa' para que el cliente siempre vea su historial
        // Se busca por user_id O por correo electrónico para capturar reservas hechas como invitado
        $reservas = Reservacion::withoutGlobalScope(\App\Models\Scopes\CafeScope::class)
            ->select('reservaciones.*')
            ->leftJoin('cafeterias', 'reservaciones.cafe_id', '=', 'cafeterias.id')
            ->with(['cafeteria:id,nombre,calle,colonia,ciudad', 'zona', 'promocion', 'ocasionEspecial'])
            ->where(function($q) use ($user) {
                $q->where('reservaciones.user_id', $user->id);
                if ($user->email) {
                    $q->orWhere('reservaciones.email', $user->email);
                }
            })
            ->orderBy('reservaciones.fecha', 'desc')
            ->orderBy('reservaciones.hora_inicio', 'desc')
            ->get()
            ->map(fn($r) => $this->formatReservacion($r));

        return ApiResponse::success($reservas, 'Reservaciones del usuario');
    }



    /**
     * Cancelar reservación
     */
    public function cancelar($id)
    {
        $reservacion = Reservacion::with('cafeteria')->findOrFail($id);
        $user = auth()->user();

        // 1. Autorización Básica
        // Clientes solo pueden cancelar lo suyo. Staff/Gerente cualquier cosa de su café.
        if ($user->role === 'cliente' && $reservacion->user_id !== $user->id) {
            return ApiResponse::error('No autorizado para cancelar esta reservación', 403);
        }

        // 2. Validación de Estado
        // Solo se puede cancelar si está pendiente.
        if ($reservacion->estado !== Reservacion::STATUS_PENDIENTE) {
            return ApiResponse::error("No se puede cancelar una reservación en estado: {$reservacion->estado}", 422);
        }

        // 3. Validación de Tiempo (Tolerancia No-Show)
        $inicio = Carbon::parse($reservacion->fecha . ' ' . $reservacion->hora_inicio);
        $tolerancia = $reservacion->cafeteria->tolerancia_reserva_min ?? 15;
        $limiteCancelacion = $inicio->copy()->addMinutes($tolerancia);

        if (now()->gt($limiteCancelacion)) {
            return ApiResponse::error('El tiempo de tolerancia ha expirado. La reservación ahora debe gestionarse como No-Show.', 422);
        }

        // 4. Ejecutar Cancelación con Auditoría
        $reservacion->update([
            'estado' => Reservacion::STATUS_CANCELADA,
            'cancelado_por_id' => $user->id,
            'cancelado_por_rol' => $user->role
        ]);

        // 5. Notificar al cliente
        if ($reservacion->email) {
            try {
                Mail::to($reservacion->email)->send(new ReservaCancelada($reservacion));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error enviando correo de cancelación (ID: {$reservacion->id}): " . $e->getMessage());
            }
        }

        return ApiResponse::success(null, 'Reservación cancelada correctamente');
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
            ->whereIn('estado', [Reservacion::STATUS_PENDIENTE, Reservacion::STATUS_ENCURSO])
            ->sum('numero_personas');


        $cafeteria = Cafeteria::find($cafeId);

        $porcentaje = max(0, min(100, $cafeteria->porcentaje_reservas ?? 50)) / 100;

        $capacidadReservable = floor($capacidadTotal * $porcentaje);

        return ($personasReservadas + $personas) <= $capacidadReservable;
    }

    public function checkin($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        $inicio = Carbon::parse($reservacion->fecha . ' ' . $reservacion->hora_inicio);

        // Permitir llegada 15 minutos antes
        $horaPermitida = $inicio->copy()->subMinutes(15);

        if (now()->lt($horaPermitida)) {
            return ApiResponse::error('Aún faltan más de 15 minutos para la reserva. No puedes marcar llegada aún.');
        }

        if ($reservacion->estado !== Reservacion::STATUS_PENDIENTE) {
            return ApiResponse::error('Solo reservaciones pendientes pueden marcarse como llegada');
        }

        $reservacion->update([
            'estado' => Reservacion::STATUS_ENCURSO,
            'fecha_checkin' => now()
        ]);

        $reservacion->load(['cafeteria', 'ocasionEspecial', 'zona', 'promocion']);

        return ApiResponse::success(
            $this->formatReservacion($reservacion),
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

        return ApiResponse::success($this->formatReservacion($r));
    }


    /**
     * Cancelar una reservación por folio (público — folio actúa como token).
     */
    public function cancelarByFolio(string $folio)
    {
        $r = Reservacion::withoutGlobalScope(\App\Models\Scopes\CafeScope::class)
            ->where('folio', $folio)
            ->firstOrFail();

        if ($r->estado === Reservacion::STATUS_CANCELADA) {
            return ApiResponse::error('Esta reservación ya fue cancelada.', 409);
        }

        if (in_array($r->estado, [Reservacion::STATUS_ENCURSO, Reservacion::STATUS_FINALIZADA])) {
            return ApiResponse::error('No se puede cancelar una reservación en curso o finalizada.', 409);
        }

        $inicio = Carbon::parse($r->fecha . ' ' . $r->hora_inicio);
        if ($inicio->isPast()) {
            return ApiResponse::error('No se puede cancelar una reservación cuya fecha u hora ya pasaron.', 409);
        }

        $r->update(['estado' => Reservacion::STATUS_CANCELADA]);

        return ApiResponse::success(null, 'Reservación cancelada correctamente.');
    }


    /**
     * Formatear reservación para respuestas JSON consistentes
     */
    private function formatReservacion($r)
    {
        return [
            'id' => $r->id,
            'folio' => $r->folio,
            'nombre_cliente' => $r->nombre_cliente,
            'telefono' => $r->telefono,
            'email' => $r->email,
            'fecha' => $r->fecha,
            'hora_inicio' => $r->hora_inicio,
            'hora_fin' => $r->hora_fin,
            'duracion_min' => $r->duracion_min,
            'numero_personas' => $r->numero_personas,
            'estado' => $r->estado,
            'comentarios' => $r->comentarios,
            'fecha_checkin' => $r->fecha_checkin,
            'fecha_checkout' => $r->fecha_checkout,
            'mesa_asignada_fisicamente' => isset($r->mesa_asignada_fisicamente) ? (bool)$r->mesa_asignada_fisicamente : false,
            'cafeteria' => $r->relationLoaded('cafeteria') && $r->cafeteria ? [
                'nombre' => $r->cafeteria->nombre,
                'calle' => $r->cafeteria->calle ?? null,
                'colonia' => $r->cafeteria->colonia ?? null,
                'ciudad' => $r->cafeteria->ciudad ?? null,
            ] : null,
            'ocasion' => $r->relationLoaded('ocasionEspecial') && $r->ocasionEspecial ? ['nombre' => $r->ocasionEspecial->nombre] : null,
            'promocion' => $r->relationLoaded('promocion') && $r->promocion ? ['nombre' => $r->promocion->nombre_promocion, 'precio' => $r->promocion->precio] : null,
            'zona' => $r->relationLoaded('zona') && $r->zona ? ['nombre' => $r->zona->nombre_zona] : null,
            'tipo' => $r->tipo ?? null,
        ];
    }
}