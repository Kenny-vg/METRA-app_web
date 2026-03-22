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

class OcupacionController extends Controller
{

    /**
     * Ver mesas ocupadas
     */
    public function index()
    {
        $ocupaciones = DetalleOcupacion::with('mesa')
            ->where('estado', 'activa')
            ->get();

        return ApiResponse::success($ocupaciones, 'Mesas ocupadas');
    }


    /**
     * Abrir mesa (sentar cliente walk-in)
     */
    public function store(Request $request)
    {

        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'zona_id' => 'required|exists:zonas,id',
            'numero_personas' => 'required|integer|min:1',
            'reservacion_id' => 'nullable|exists:reservaciones,id',
            'nombre_cliente' => 'nullable|string|max:150',
            'email' => 'nullable|email',
            'comentarios' => 'nullable|string|max:255'
        ]);

        $reservacion = null;

        if ($request->reservacion_id) {
            $reservacion = Reservacion::find($request->reservacion_id);

            if (!$reservacion || $reservacion->estado !== 'pendiente') {
                return ApiResponse::error('La reservación no está disponible para ocupar');
            }

            $yaOcupada = DetalleOcupacion::where('reservacion_id', $request->reservacion_id)
                ->where('estado', 'activa')
                ->exists();

            if ($yaOcupada) {
                return ApiResponse::error('Esta reservación ya está en uso');
            }
        }

        $mesa = Mesa::find($request->mesa_id);

        if (!$mesa) {
            return ApiResponse::error('Mesa no encontrada');
        }

        if ($request->numero_personas > $mesa->capacidad) {
            return ApiResponse::error('La mesa no tiene capacidad suficiente');
        }

        $ocupada = DetalleOcupacion::where('mesa_id', $request->mesa_id)
            ->where('estado', 'activa')
            ->exists();

        if ($ocupada) {
            return ApiResponse::error('La mesa ya está ocupada');
        }

        $ocupacion = DetalleOcupacion::create([
            'mesa_id' => $request->mesa_id,
            'numero_personas' => $request->numero_personas,
            'reservacion_id' => $request->reservacion_id,
            'tipo' => $request->reservacion_id ? 'reservacion' : 'walkin',
            'nombre_cliente' => $request->nombre_cliente,
            'email' => $request->email,
            'comentarios' => $request->comentarios,
            'hora_entrada' => now(),
            'estado' => 'activa',
            'token_resena' => ($request->email || ($reservacion && $reservacion->email)) ? Str::random(40) : null,
            'cafe_id' => auth()->user()->cafe_id,
            'user_id' => auth()->id()
        ]);

        // Actualizar reservación si existe
        if ($reservacion) {
            $reservacion->update([
                'estado' => 'en_curso',
                'fecha_checkin' => now()
            ]);
        }

        return ApiResponse::success($ocupacion, 'Mesa abierta');
    }

    /**
     * Cerrar mesa (cliente se va/paga)
     */
    public function finalizar($id)
    {
        $ocupacion = DetalleOcupacion::findOrFail($id);

        if ($ocupacion->estado !== 'activa') {
            return ApiResponse::error('La mesa ya está cerrada');
        }

        //cerrar ocupacion
        $ocupacion->update([
            'estado' => 'finalizada',
            'hora_salida' => now()
        ]);

         // Actualizar reservación si existe
        $reservacion = $ocupacion->reservacion;

        if ($reservacion && $reservacion->estado === 'en_curso') {
            $reservacion->update([
                'estado' => 'finalizada',
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
        $ocupadas = DetalleOcupacion::where('estado', 'activa')->pluck('mesa_id')->toArray();

        $mesas = Mesa::with('zona')->get()->map(function ($mesa) use ($ocupadas) {
            return [
            'id' => $mesa->id,
            'numero' => $mesa->numero,
            'capacidad' => $mesa->capacidad,
            'zona' => $mesa->zona->nombre,
            'estado' => in_array($mesa->id, $ocupadas) ? 'ocupada' : 'libre'
            ];
        });

        return ApiResponse::success($mesas, 'Estado de mesas');
    }
}