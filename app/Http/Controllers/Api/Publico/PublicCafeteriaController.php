<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\OcasionEspecial;
use App\Models\MenuCategoria;
use App\Models\Promocion;
use App\Models\Zona;
use App\Models\Horario;
use App\Models\Mesa;
use App\Helpers\ApiResponse;
use App\Models\Resena;

class PublicCafeteriaController extends Controller
{
    /**
     * Cafeterías activas (uso público: landing page)
     */
    public function index()
    {
        $cafeterias = Cafeteria::where('estado', 'activa')
            ->select(
            'id',
            'slug',
            'nombre',
            'descripcion',
            'calle',
            'num_exterior',
            'colonia',
            'foto_url'
        )
            ->get();

        return ApiResponse::success($cafeterias);
    }

    /**
     * Ver cafetería
     */
    public function show(Cafeteria $cafeteria)
    {
        return ApiResponse::success($cafeteria);
    }

    /**
     * Ver menú
     */
    public function menu(Cafeteria $cafeteria)
    {
        $menuAgrupado = MenuCategoria::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->has('menus') // Solo categorías con productos
            ->orderBy('orden')
            ->with(['menus' => function ($q) {
                $q->where('activo', true)->orderBy('orden');
            }])
            ->get();

        return ApiResponse::success($menuAgrupado);
    }

    /**
     * Ver ocasiones especiales
     */
    public function ocasiones(Cafeteria $cafeteria)
    {
        $ocasiones = OcasionEspecial::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return ApiResponse::success($ocasiones);
    }

    /**
     * Ver promociones ligadas a ocasiones (mantiene compatibilidad con rutas antiguas)
     */
    public function promocionesPorOcasion(\Illuminate\Http\Request $request, Cafeteria $cafeteria, $ocasion)
    {
        $request->merge(['ocasion_id' => $ocasion]);
        return $this->promociones($request, $cafeteria);
    }

    /**
     * Zonas activas (público — para el formulario de reserva)
     */
    public function zonas(Cafeteria $cafeteria)
    {
        $zonas = Zona::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->orderBy('nombre_zona')
            ->get(['id', 'nombre_zona']);

        return ApiResponse::success($zonas);
    }

    /**
     * Horarios activos (público)
     */
    public function horarios(Cafeteria $cafeteria)
    {
        $horarios = Horario::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->orderBy('hora_apertura')
            ->get(['id', 'dia_semana', 'hora_apertura', 'hora_cierre']);

        return ApiResponse::success($horarios);
    }

    /**
     * Obtener la capacidad máxima basada en la mesa más grande
     */
    public function mesasCapacidad(Cafeteria $cafeteria)
    {
        $maxCapacidad = Mesa::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->max('capacidad') ?? 1; // Default a 1 si no hay mesas activas

        return ApiResponse::success(['max_capacidad' => $maxCapacidad]);
    }

    /**
     * Ver promociones (con filtrado automático por fecha, hora y ocasión)
     */
    public function promociones(\Illuminate\Http\Request $request, Cafeteria $cafeteria)
    {
        $query = Promocion::where('cafe_id', $cafeteria->id)
            ->where('activo', true);

        // 1. Filtrado por Fecha
        if ($request->filled('fecha')) {
            $fecha = $request->fecha;
            $query->where(function ($q) use ($fecha) {
                $q->whereNull('fecha_inicio')->orWhere('fecha_inicio', '<=', $fecha);
            })->where(function ($q) use ($fecha) {
                $q->whereNull('fecha_fin')->orWhere('fecha_fin', '>=', $fecha);
            });

            // Filtrado por día de la semana
            $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
            $diaNombre = $dias[date('w', strtotime($fecha))];
            
            $query->where(function ($q) use ($diaNombre) {
                $q->whereNull('dias_semana')
                  ->orWhereJsonContains('dias_semana', $diaNombre);
            });
        }

        // 2. Filtrado por Hora
        if ($request->filled('hora')) {
            $hora = $request->hora;
            $query->where(function ($q) use ($hora) {
                $q->whereNull('hora_inicio')->orWhere('hora_inicio', '<=', $hora);
            })->where(function ($q) use ($hora) {
                $q->whereNull('hora_fin')->orWhere('hora_fin', '>=', $hora);
            });
        }

        // 3. Filtrado por Ocasión
        if ($request->filled('ocasion_id')) {
            $ocasionId = $request->ocasion_id;
            $query->where(function ($q) use ($ocasionId) {
                $q->doesntHave('ocasiones') // Promociones Generales
                  ->orWhereHas('ocasiones', function ($q2) use ($ocasionId) {
                      $q2->where('ocasion_especials.id', $ocasionId); // Específicas de la ocasión
                  });
            });
        } else {
            // Si no hay ocasión seleccionada, mostrar solo las Generales
            $query->doesntHave('ocasiones');
        }

        $promociones = $query->orderBy('nombre_promocion')->get();

        return ApiResponse::success($promociones);
    }

    /**
     * Ver reseñas
     */
    public function resenas(Cafeteria $cafeteria)
    {
        $resenas = \App\Models\Resena::where('cafe_id', $cafeteria->id)
            ->where('estado', 'publicada')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($r) {

            return [
            'calificacion' => $r->calificacion,
            'comentario' => $r->comentario,
            'fecha' => $r->created_at->format('d M Y')
            ];

        });

        return ApiResponse::success($resenas, 'Reseñas');
    }
}
