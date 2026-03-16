<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetalleOcupacion;
use App\Models\Mesa;
use App\Models\Reservacion;
use App\Helpers\ApiResponse;

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

        $mesa = Mesa::where('id', $request->mesa_id)
            ->where('zona_id', $request->zona_id)
            ->first();

        if (!$mesa) {
            return ApiResponse::error('La mesa no pertenece a la zona seleccionada');
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
            'cafe_id' => auth()->user()->cafe_id,
            'user_id' => auth()->id()
        ]);

        return ApiResponse::success($ocupacion, 'Mesa abierta');
    }


    /**
     * Cerrar mesa (cliente se va)
     */
    public function finalizar($id)
    {
        $ocupacion = DetalleOcupacion::findOrFail($id);

        if ($ocupacion->estado !== 'activa') {
            return ApiResponse::error('La mesa ya está cerrada');
        }

        $ocupacion->update([
            'estado' => 'finalizada',
            'hora_salida' => now()
        ]);

        return ApiResponse::success($ocupacion, 'Mesa cerrada');
    }

    public function estadoMesas()
    {
        $mesas = Mesa::with('zona')->get()->map(function ($mesa) {

            // Ver si la mesa está ocupada
            $ocupada = DetalleOcupacion::where('mesa_id', $mesa->id)
                ->where('estado', 'activa')
                ->exists();

            // Ver reservación próxima
            $reservacion = Reservacion::where('mesa_id', $mesa->id)
                ->where('fecha', today())
                ->where('estado', 'confirmada')
                ->orderBy('hora_inicio')
                ->first();

            $estado = 'libre';
            $hora_reserva = null;

            if ($ocupada) {
                $estado = 'ocupada';
            }
            elseif ($reservacion) {
                $estado = 'reservada';
                $hora_reserva = $reservacion->hora_inicio;
            }

            return [
            'id' => $mesa->id,
            'numero' => $mesa->numero,
            'capacidad' => $mesa->capacidad,
            'zona' => $mesa->zona->nombre,
            'estado' => $estado,
            'hora_reserva' => $hora_reserva
            ];
        });

        return ApiResponse::success($mesas, 'Estado de mesas');
    }


}