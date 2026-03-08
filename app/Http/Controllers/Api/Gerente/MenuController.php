<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Helpers\ApiResponse;
use App\Traits\Activable;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    use Activable;

    protected $model = Menu::class;

    public function index(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $menu = Menu::where('cafe_id',$cafeId)
            ->orderBy('nombre_producto')
            ->get();

        return ApiResponse::success($menu);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto'=>'required|string|max:100',
            'descripcion'=>'nullable|string|max:255',
            'imagen_url'=>'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $data = [
            'nombre_producto'=>$request->nombre_producto,
            'descripcion'=>$request->descripcion,
            'activo'=>true,
            'cafe_id'=>$request->user()->cafe_id
        ];

        if ($request->hasFile('imagen_url')) {
            $path = $request->file('imagen_url')->store('menus', 'public');
            $data['imagen_url'] = $path;
        }

        $menu = Menu::create($data);

        return ApiResponse::success($menu,'Producto agregado al menú');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'nombre_producto'=>'required|string|max:100',
            'descripcion'=>'nullable|string|max:255',
            'imagen_url'=>'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $menu = Menu::where('id',$id)
            ->where('cafe_id',$request->user()->cafe_id)
            ->first();

        if(!$menu){
            return ApiResponse::error('Producto no encontrado',404);
        }

        $data = [
            'nombre_producto'=>$request->nombre_producto,
            'descripcion'=>$request->descripcion,
        ];

        if ($request->hasFile('imagen_url')) {
            // borrar vieja si existe
            if ($menu->imagen_url) {
                Storage::disk('public')->delete($menu->imagen_url);
            }
            $path = $request->file('imagen_url')->store('menus', 'public');
            $data['imagen_url'] = $path;
        }

        $menu->update($data);

        return ApiResponse::success($menu,'Producto actualizado');
    }

    public function destroy(Request $request,$id)
    {
        $menu = Menu::where('id',$id)
            ->where('cafe_id',$request->user()->cafe_id)
            ->first();

        if(!$menu){
            return ApiResponse::error('Producto no encontrado',404);
        }

        $menu->update([
            'activo'=>false
        ]);

        return ApiResponse::success($menu,'Producto desactivado');
    }
}