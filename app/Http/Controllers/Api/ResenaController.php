<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetalleOcupacion;
use App\Models\Resena;
use App\Helpers\ApiResponse;

class ResenaController extends Controller
{

    /**
     * Mostrar datos para dejar reseña (link del correo)
     */
    public function show($token)
    {
        $ocupacion = DetalleOcupacion::with(['cafeteria', 'mesa'])
            ->where('token_resena', $token)
            ->first();

        if (!$ocupacion) {
            return ApiResponse::error('Este enlace de reseña no es válido', 404);
        }

        if ($ocupacion->resena) {
            return ApiResponse::error('Esta reseña ya fue enviada');
        }

        return ApiResponse::success([
            'cafeteria' => $ocupacion->cafeteria->nombre ?? null,
            'mesa' => $ocupacion->mesa->numero ?? null,
            'fecha_visita' => $ocupacion->hora_entrada
        ], 'Datos para reseña');
    }


    /**
     * Guardar reseña del cliente
     */
    public function store(Request $request, $token)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:255'
        ]);

        $ocupacion = DetalleOcupacion::where('token_resena', $token)->first();

        if (!$ocupacion) {
            return ApiResponse::error('Este enlace ya no es válido', 404);
        }

        if ($ocupacion->resena) {
            return ApiResponse::error('Esta reseña ya fue registrada');
        }

        $resena = Resena::create([
            'detalle_ocupacion_id' => $ocupacion->id,
            'cafe_id' => $ocupacion->cafe_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'estado' => 'pendiente'
        ]);

        // invalidar token para evitar duplicados
        $ocupacion->update([
            'token_resena' => null
        ]);

        return ApiResponse::success($resena, 'Gracias por tu reseña');
    }


    /**
     * Listar reseñas para el gerente
     */
    public function index()
    {
        $resenas = Resena::latest()->get();

        return ApiResponse::success($resenas, 'Reseñas de la cafetería');
    }


    /**
     * Aprobar reseña
     */
    public function aprobar($id)
    {
        $resena = Resena::findOrFail($id);

        $resena->update([
            'estado' => 'publicada'
        ]);

        return ApiResponse::success($resena, 'Reseña publicada');
    }


    /**
     * Ocultar reseña
     */
    public function ocultar($id)
    {
        $resena = Resena::findOrFail($id);

        $resena->update([
            'estado' => 'oculta'
        ]);

        return ApiResponse::success($resena, 'Reseña ocultada');
    }

}