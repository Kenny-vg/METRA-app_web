<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OcasionEspecial;
use App\Helpers\ApiResponse;
use App\Traits\Activable;
use Illuminate\Validation\Rule;


class OcasionController extends Controller
{
    use Activable;

    protected $model = OcasionEspecial::class;


    /**LISTAR OCASIONES */
    public function index(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $ocasiones = OcasionEspecial::where('cafe_id', $cafeId)
            ->orderBy('nombre')
            ->get();

        return ApiResponse::success($ocasiones);
    }

    /**CREAR OCASION */
    public function store(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ocasion_especials')->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
        ],[
            'nombre.unique' => 'Ya existe una ocasión con ese nombre en tu cafetería'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => true,
            'cafe_id' => $cafeId
        ];

        $ocasion = OcasionEspecial::create($data);

        return ApiResponse::success($ocasion, 'Ocasion agregada');
    }

    public function update(Request $request, $id)
    {
        $cafeId = $request->user()->cafe_id;

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ocasion_especials')->ignore($id)->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ocasion = OcasionEspecial::where('id', $id)
            ->where('cafe_id', $cafeId)
            ->first();

        if (!$ocasion) {
            return ApiResponse::error('Ocasion no encontrada', 404);
        }

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ];

        $ocasion->update($data);

        return ApiResponse::success($ocasion, 'Ocasion actualizada');
    }

    public function destroy(Request $request, $id)
    {
        $ocasion = OcasionEspecial::where('id', $id)
            ->where('cafe_id', cafe_id)
            ->first();

        if (!$ocasion) {
            return ApiResponse::error('Ocasion no encontrada', 404);
        }

        $ocasion->update([
            'activo' => false
        ]);

        return ApiResponse::success($ocasion, 'Ocasion desactivada');
    }
}
