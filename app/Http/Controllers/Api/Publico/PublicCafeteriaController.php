<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Cafeteria;
use App\Models\Menu;
use App\Models\OcasionEspecial;
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
        $menu = Menu::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->orderBy('nombre_producto')
            ->get();

        return ApiResponse::success($menu);
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
     * Ver promociones ligadas a ocasiones
     */
    public function promocionesPorOcasion(Cafeteria $cafeteria, $ocasion)
    {
        $promociones = Promocion::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->whereHas('ocasiones', function ($q) use ($ocasion) {
            $q->where('ocasion_especials.id', $ocasion);
        })
            ->orderBy('nombre_promocion')
            ->get();

        return ApiResponse::success($promociones);
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
     * Ver promociones
     */
    public function promociones(Cafeteria $cafeteria)
    {
        $promociones = Promocion::where('cafe_id', $cafeteria->id)
            ->where('activo', true)
            ->orderBy('nombre_promocion')
            ->get();

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
