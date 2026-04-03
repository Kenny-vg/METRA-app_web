<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Helpers\ApiResponse;
use App\Traits\Activable;
use App\Services\CloudinaryService;
use App\Models\MenuCategoria;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    use Activable;

    protected $model = Menu::class;
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    public function index(Request $request)
    {
        $menuAgrupado = MenuCategoria::orderBy('orden')
            ->with(['menus' => fn($q) => $q->orderBy('orden')])
            ->get();

        return ApiResponse::success($menuAgrupado);
    }

    public function store(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $request->merge([
            'nombre_producto' => $request->nombre_producto ? strip_tags($request->nombre_producto) : null,
            'descripcion' => $request->descripcion ? strip_tags($request->descripcion) : null,
        ]);

        $request->validate([
            'nombre_producto' => [
                'required',
                'string',
                'max:100',
                Rule::unique('menus')->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
            'imagen_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'categoria_id' => [
                'required',
                Rule::exists('menu_categorias', 'id')->where('cafe_id', $cafeId)
            ],
            'precio' => 'required|numeric|min:0',
            'orden' => 'nullable|integer'
        ]);

        $data = [
            'nombre_producto' => $request->nombre_producto,
            'descripcion' => $request->descripcion,
            'activo' => true,
            'orden' => $request->orden ?? 0,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'cafe_id' => $request->user()->cafe_id
        ];

        if ($request->hasFile('imagen_url')) {
            try {
                $result = $this->cloudinary->upload($request->file('imagen_url'), 'metra/menus');
                $data['imagen_url'] = $result['url'];
                $data['imagen_public_id'] = $result['public_id'];
            } catch (\Throwable $e) {
                \Log::error("Error Cloudinary upload menú: " . $e->getMessage());
                return ApiResponse::error('Error al subir la imagen a Cloudinary', 500);
            }
        }

        $menu = Menu::create($data);

        return ApiResponse::success($menu, 'Producto agregado al menú');
    }

    public function update(Request $request, Menu $menu)
    {
        $cafeId = $request->user()->cafe_id;

        $request->merge([
            'nombre_producto' => $request->nombre_producto ? strip_tags($request->nombre_producto) : null,
            'descripcion' => $request->descripcion ? strip_tags($request->descripcion) : null,
        ]);

        $request->validate([
            'nombre_producto' => [
                'required',
                'string',
                'max:100',
                Rule::unique('menus')->ignore($menu->id)->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion' => 'nullable|string|max:255',
            'imagen_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'categoria_id' => [
                'sometimes',
                'required',
                Rule::exists('menu_categorias', 'id')->where('cafe_id', $cafeId)
            ],
            'precio' => 'sometimes|required|numeric|min:0',
            'orden' => 'nullable|integer'
        ]);

        $data = [
            'nombre_producto' => $request->nombre_producto,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id ?? $menu->categoria_id,
            'orden' => $request->orden ?? $menu->orden,
            'precio' => $request->has('precio') ? $request->precio : $menu->precio,
            'activo' => $request->has('activo') ? $request->boolean('activo') : $menu->activo,
        ];

        if ($request->hasFile('imagen_url')) {
            try {
                // Borrar la anterior de Cloudinary si existe
                $this->cloudinary->delete($menu->imagen_public_id);

                // Subir la nueva
                $result = $this->cloudinary->upload($request->file('imagen_url'), 'metra/menus');
                $data['imagen_url'] = $result['url'];
                $data['imagen_public_id'] = $result['public_id'];
            } catch (\Throwable $e) {
                \Log::error("Error Cloudinary update menú: " . $e->getMessage());
                return ApiResponse::error('Error al subir la imagen a Cloudinary', 500);
            }
        }

        $menu->update($data);

        return ApiResponse::success($menu, 'Producto actualizado');
    }

    public function destroy(Request $request, Menu $menu)
    {
        $menu->update([
            'activo' => false
        ]);

        return ApiResponse::success($menu, 'Producto desactivado');
    }
}