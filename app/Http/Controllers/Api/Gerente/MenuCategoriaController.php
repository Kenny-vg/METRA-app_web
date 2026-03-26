<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuCategoria;
use App\Helpers\ApiResponse;
use Illuminate\Validation\Rule;
use App\Traits\Activable;

class MenuCategoriaController extends Controller
{
    use Activable;
    protected $model = MenuCategoria::class;

    /**
     * LISTAR CATEGORÍAS
     */
    public function index()
    {
        $categorias = MenuCategoria::orderBy('orden')->get();
        return ApiResponse::success($categorias);
    }

    /**
     * CREAR CATEGORÍA
     */
    public function store(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('menu_categorias')->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
            'orden' => 'nullable|integer'
        ]);

        $categoria = MenuCategoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0,
            'activo' => true,
            'cafe_id' => $cafeId
        ]);

        return ApiResponse::success($categoria, 'Categoría creada exitosamente');
    }

    /**
     * ACTUALIZAR CATEGORÍA
     */
    public function update(Request $request, MenuCategoria $menuCategoria)
    {
        $request->validate([
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('menu_categorias')->where('cafe_id', $menuCategoria->cafe_id)->ignore($menuCategoria->id)
            ],
            'descripcion' => 'nullable|string|max:255',
            'orden' => 'nullable|integer',
            'activo' => 'nullable|boolean'
        ]);

        $menuCategoria->update($request->only(['nombre', 'descripcion', 'orden', 'activo']));

        return ApiResponse::success($menuCategoria, 'Categoría actualizada exitosamente');
    }

    /**
     * ELIMINAR (DESACTIVAR) CATEGORÍA
     */
    public function destroy(MenuCategoria $menuCategoria)
    {
        $menuCategoria->update(['activo' => false]);
        return ApiResponse::success(null, 'Categoría desactivada');
    }
}
