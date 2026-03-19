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
        $ocasiones = OcasionEspecial::orderBy('nombre')->get();

        return ApiResponse::success($ocasiones);
    }

    /**CREAR OCASION */
    public function store(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        // Limpiar inputs de HTML (Protección XSS)
        $request->merge([
            'nombre'      => $request->filled('nombre') ? strip_tags($request->nombre) : null,
            'descripcion' => $request->filled('descripcion') ? strip_tags($request->descripcion) : null,
        ]);

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

    public function update(Request $request, OcasionEspecial $ocasion)
    {
        $cafeId = $request->user()->cafe_id;

        // Limpiar inputs de HTML (Protección XSS)
        $request->merge([
            'nombre'      => $request->filled('nombre') ? strip_tags($request->nombre) : null,
            'descripcion' => $request->filled('descripcion') ? strip_tags($request->descripcion) : null,
        ]);

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ocasion_especials')->ignore($ocasion->id)->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ];

        $ocasion->update($data);

        return ApiResponse::success($ocasion, 'Ocasion actualizada');
    }

    public function destroy(Request $request, OcasionEspecial $ocasion)
    {
        $ocasion->update([
            'activo' => false
        ]);

        return ApiResponse::success($ocasion, 'Ocasion desactivada');
    }
}
