<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Mesa;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->cafe_id) {
            return ApiResponse::error('No autorizado', 403);
        }

        $modo = $request->query('modo');

        $query = Reservacion::where('id_cafeteria', $user->cafe_id);

        if ($modo === 'futuras') {
            $today = Carbon::today()->toDateString();
            $nowTime = Carbon::now()->format('H:i:s');
            
            $query->where(function($q) use ($today, $nowTime) {
                $q->whereDate('fecha', '>', $today)
                  ->orWhere(function($q2) use ($today, $nowTime) {
                      $q2->whereDate('fecha', '=', $today)
                         ->where('hora_inicio', '>=', $nowTime);
                  });
            })
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc');
        } else {
            $fecha = $request->query('fecha', Carbon::today()->toDateString());
            $query->whereDate('fecha', $fecha)
                  ->orderBy('hora_inicio', 'asc');
        }

        $reservaciones = $query->get();

        return ApiResponse::success($reservaciones);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_cliente' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telefono' => 'required|string|max:20',
                'fecha' => 'required|date',
                'hora_inicio' => 'required',
                'numero_personas' => 'required|integer|min:1',
                'id_cafeteria' => 'required|exists:cafeterias,id',
                'id_ocasion' => 'nullable|exists:ocasion_especials,id',
                'id_promocion' => 'nullable|exists:promocions,id',
                'comentarios' => 'nullable|string'
            ]);

            // Validar capacidad máxima de grupo
            $maxCapacidad = Mesa::where('cafe_id', $validated['id_cafeteria'])
                                ->where('activo', true)
                                ->max('capacidad') ?? 1;

            if ($validated['numero_personas'] > $maxCapacidad) {
                return ApiResponse::error('El número de personas excede la capacidad máxima disponible.', 422);
            }

            $folio = 'RES-' . strtoupper(Str::random(6));

            // Default a +2 horas de la hora_inicio
            $horaInicio = Carbon::parse($validated['hora_inicio'])->format('H:i');
            $horaFin = Carbon::parse($validated['hora_inicio'])->addHours(2)->format('H:i');

            $reservacion = Reservacion::create([
                'folio' => $folio,
                'nombre_cliente' => $validated['nombre_cliente'],
                'telefono' => $validated['telefono'],
                'email' => $validated['email'],
                'fecha' => $validated['fecha'],
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
                'numero_personas' => $validated['numero_personas'],
                'estado' => 'confirmada',
                'id_cafeteria' => $validated['id_cafeteria'],
                'id_ocasion' => $validated['id_ocasion'] ?? null,
                'id_promocion' => $validated['id_promocion'] ?? null,
                'comentarios' => $validated['comentarios'] ?? null
            ]);

            // Cargar datos relacionados para el comprobante
            $reservacion->load(['cafeteria', 'ocasion', 'promocion']);

            return ApiResponse::success($reservacion, 'Reservación creada con éxito.', 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return ApiResponse::error('Error al guardar: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Devuelve la vista de comprobante con los datos verificados de la base de datos
     */
    public function confirmacion($folio)
    {
        $reservacion = Reservacion::where('folio', $folio)
            ->with(['cafeteria', 'ocasion'])->firstOrFail();
            
        // Extraemos la zona desde el query de conveniencia en JS
        $zonaPreferida = request()->query('zona', 'Sin Preferencia');
        
        return view('public.confirmacion', compact('reservacion', 'zonaPreferida'));
    }
}
