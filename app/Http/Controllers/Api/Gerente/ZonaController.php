<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zona;
use App\Helpers\ApiResponse;
use App\Traits\Activable;
use Illuminate\Validation\Rule;

class ZonaController extends Controller
{
    use Activable;
    protected $model = Zona::class;
    /**
     * LISTAR ZONAS
     */
    public function index(Request $request)
    {
        $zonas = Zona::orderBy('nombre_zona')->get();

        return ApiResponse::success($zonas);

    }

    /**
     * CREAR ZONA
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_zona' => [
                'required',
                'string',
                'max:100',
                Rule::unique('zonas')
                ->where('cafe_id', $request->user()->cafe_id)
            ],
        ]);

        $cafeId = $request->user()->cafe_id;

        $zona = Zona::create([
            'nombre_zona' => $request->nombre_zona,
            'activo' => true,
            'cafe_id' => $cafeId
        ]);

        return ApiResponse::success($zona, 'Zona creada correctamente');
    }



    /**
     * ACTUALIZAR ZONA
     */
    public function update(Request $request, Zona $zona)
    {
        $request->validate([
            'nombre_zona' => [
                'required',
                'string',
                'max:100',
                Rule::unique('zonas')
                ->where('cafe_id', $request->user()->cafe_id)
                ->ignore($zona->id)
            ],
        ]);

        $zona->update([
            'nombre_zona' => $request->nombre_zona,
        ]);

        return ApiResponse::success($zona, 'Zona actualizada correctamente');
    }


    /**
     * DESACTIVAR ZONA
     */
    public function destroy(Zona $zona)
    {
        $zona->update([
            'activo' => false,
        ]);

        $zona->mesas()->update([
            'activo' => false,
        ]);

        return ApiResponse::success(null, 'Zona y sus mesas desactivadas correctamente');
    }
}
