<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zona;
use App\Helpers\ApiResponse;

class ZonaController extends Controller
{
    /**
     * LISTAR ZONAS
     */
    public function index(Request $request)
    {
        $cafeId= $request->user()->cafe_id;

        $zonas= Zona::where('cafe_id', $cafeId)
                            ->where('activo', true)
                            ->orderBy('nombre_zona')
                            ->get();

        return ApiResponse::success($zonas);

    }

    /**
     * CREAR ZONA
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_zona'=>'required|string|max:100',
        ]);

        $cafeId= $request->user()->cafe_id;

        //verificar duplicado
        $existe = Zona::where('cafe_id', $cafeId)
                            ->where('nombre_zona', $request->nombre_zona)
                            ->exists();

        if($existe){
            return ApiResponse::error('Ya existe una zona con ese nombre', 400);
        }

        $zona = Zona::create([
            'nombre_zona'=>$request->nombre_zona,
            'activo'=>true,
            'cafe_id'=>$cafeId
        ]);

        return ApiResponse::success($zona, 'Zona creada correctamente');
    }



    /**
     * ACTUALIZAR ZONA
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_zona'=>'required|string|max:100',
        ]);

        $zona = Zona::where('id', $id)
                            ->where('cafe_id', $request->user()->cafe_id)
                            ->first();

        if(!$zona){
            return ApiResponse::error('Zona no encontrada', 404);
        }

        $zona->update([
            'nombre_zona'=>$request->nombre_zona,
        ]);

        return ApiResponse::success($zona, 'Zona actualizada correctamente');
    }

    /**
     * DESACTIVAR ZONA
     */
    public function destroy(Request $request, string $id)
    {
        $zona = Zona::where('id', $id)
                            ->where('cafe_id', $request->user()->cafe_id)
                            ->first();

        if(!$zona){
            return ApiResponse::error('Zona no encontrada', 404);
        }

        $zona->update([
            'activo'=>false,
        ]);

        return ApiResponse::success($zona, 'Zona desactivada correctamente');
    }
}
