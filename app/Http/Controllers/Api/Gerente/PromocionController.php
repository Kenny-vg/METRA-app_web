<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocion;
use App\Helpers\ApiResponse;
use Illuminate\Validation\Rule;
use App\Traits\Activable;

class PromocionController extends Controller
{
    use Activable;
    protected $model = Promocion::class;

    /**
     * LISTAR PROMOCIONES
     */
    public function index()
    {
        $promociones = Promocion::with('ocasiones')->orderBy('nombre_promocion')->get();

        return ApiResponse::success($promociones);
    }

    /**
     * CREAR PROMOCIÓN
     */
    public function store(Request $request)
    {
        $cafeId = $request->user()->cafe_id;
    
        $messages = [
            'nombre_promocion.required' => 'El nombre de la promoción es obligatorio.',
            'nombre_promocion.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre_promocion.unique' => 'Ya existe una promoción con este nombre.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'ocasiones.array' => 'El formato de las ocasiones no es válido.',
        ];

        $request->merge([
            'nombre_promocion' => $request->nombre_promocion ? strip_tags($request->nombre_promocion) : null,
            'descripcion' => $request->descripcion ? strip_tags($request->descripcion) : null,
        ]);

        $request->validate([
            'nombre_promocion'=>[
                'required',
                'string',
                'max:100',
                Rule::unique('promocions')
                ->where(fn($query) => $query->where('cafe_id', $cafeId))
            ],
            'descripcion'=>'nullable|string|max:255',
            'precio'=>'required|numeric|min:0',
            'ocasiones'=>'nullable|array',
            'fecha_inicio'=>'nullable|date|after_or_equal:today',
            'fecha_fin'=>'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'=>'nullable|date_format:H:i',
            'hora_fin'=>'nullable|date_format:H:i|after:hora_inicio',
            'dias_semana'=>'nullable|array'
        ], $messages);

        $promocion = Promocion::create([
            'nombre_promocion'=>$request->nombre_promocion,
            'descripcion'=>$request->descripcion,
            'precio'=>$request->precio,
            'fecha_inicio'=>$request->fecha_inicio,
            'fecha_fin'=>$request->fecha_fin,
            'hora_inicio'=>$request->hora_inicio,
            'hora_fin'=>$request->hora_fin,
            'dias_semana'=>$request->dias_semana,
            'activo'=>true,
            'cafe_id'=>$cafeId
        ]);

        if ($request->has('ocasiones')) {
            $promocion->ocasiones()->attach($request->ocasiones);
        }

        return ApiResponse::success($promocion, 'Promoción creada exitosamente');
    }

    /**
     * ACTUALIZAR PROMOCIÓN
     */
    public function update(Request $request, Promocion $promocion)
    {
        $messages = [
            'nombre_promocion.required' => 'El nombre de la promoción es obligatorio.',
            'nombre_promocion.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre_promocion.unique' => 'Ya existe una promoción con este nombre.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'ocasiones.array' => 'El formato de las ocasiones no es válido.',
        ];

        $request->merge([
            'nombre_promocion' => $request->nombre_promocion ? strip_tags($request->nombre_promocion) : null,
            'descripcion' => $request->descripcion ? strip_tags($request->descripcion) : null,
        ]);

        $request->validate([
            'nombre_promocion'=>[
                'required',
                'string',
                'max:100',
                Rule::unique('promocions')->where('cafe_id', $promocion->cafe_id)->ignore($promocion->id)
            ],
            'descripcion'=>'nullable|string|max:255',
            'precio'=>'required|numeric|min:0',
            'ocasiones'=>'nullable|array',
            'fecha_inicio'=>'nullable|date|after_or_equal:today',
            'fecha_fin'=>'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'=>'nullable|date_format:H:i',
            'hora_fin'=>'nullable|date_format:H:i|after:hora_inicio',
            'dias_semana'=>'nullable|array'
        ], $messages);

        $promocion->update([
            'nombre_promocion' => $request->nombre_promocion,
            'descripcion'      => $request->input('descripcion', $promocion->descripcion),
            'precio'           => $request->precio,
            'fecha_inicio'     => $request->fecha_inicio,
            'fecha_fin'        => $request->fecha_fin,
            'hora_inicio'      => $request->hora_inicio,
            'hora_fin'         => $request->hora_fin,
            'dias_semana'      => $request->dias_semana,
            'activo'           => $request->has('activo') ? $request->boolean('activo') : $promocion->activo,
        ]);

        if ($request->has('ocasiones')) {
            $promocion->ocasiones()->sync($request->ocasiones);
        }

        return ApiResponse::success($promocion, 'Promoción actualizada exitosamente');
    }

    public function destroy(Promocion $promocion)
    {
        $promocion->update([
            'activo' => false
        ]);

        return ApiResponse::success(null, 'Promoción desactivada');
    }
}
