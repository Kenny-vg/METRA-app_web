<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Zona;
use App\Helpers\ApiResponse;
use App\Traits\Activable;

class MesaController extends Controller
{
    use Activable;
    protected $model = Mesa::class;
    /**
     * Listar mesas
     */
    public function index(Request $request)
    {
        $mesas = Mesa::with('zona:id,nombre_zona')
        ->orderBy('numero_mesa')
        ->get();

        return ApiResponse::success($mesas);
    }

    /**
     * CREAR MESA
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_mesa'=>'required|integer|min:1|max:127',
            'capacidad'=>'required|integer|min:1|max:127',
            'zona_id'=>'required|exists:zonas,id',
        ], [
            'numero_mesa.min' => 'El número de mesa debe ser al menos 1',
            'numero_mesa.max' => 'El número de mesa no puede ser mayor a 127',
            'numero_mesa.integer' => 'El número de mesa debe ser un número válido',
            'numero_mesa.required' => 'El número de mesa es obligatorio',
            'capacidad.min' => 'La capacidad debe ser de al menos 1 persona',
            'capacidad.max' => 'La capacidad no puede exceder las 127 personas',
            'capacidad.integer' => 'La capacidad debe ser un número válido',
            'capacidad.required' => 'La capacidad es obligatoria',
            'zona_id.required' => 'Debe seleccionar una zona',
            'zona_id.exists' => 'La zona seleccionada no existe'
        ]);

        $cafeId = $request->user()->cafe_id;

        //validar que la zona pertenezca a la cafetería
        $zona = Zona::find($request->zona_id);

        if (!$zona) {
            return ApiResponse::error('La zona no pertenece a la cafetería',400);
        }

        //evitar mesas duplicadas
        $existe=Mesa::where('zona_id',$request->zona_id)
        ->where('numero_mesa',$request->numero_mesa)
        ->exists();

        if ($existe) {
            return ApiResponse::error('Ya existe una mesa con el mismo número en esa zona',400);
        }

        $mesa = Mesa::create([
            'numero_mesa'=>$request->numero_mesa,
            'capacidad'=>$request->capacidad,
            'activo'=>true,
            'zona_id'=>$request->zona_id,
            'cafe_id'=>$cafeId,
        ]);

        return ApiResponse::success($mesa, 'Mesa creada correctamente');
    }


    /**
     * ACTUALIZAR MESA
     */
    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'numero_mesa'=>'required|integer|min:1|max:127',
            'capacidad'=>'required|integer|min:1|max:127',
            'zona_id'=>'required|exists:zonas,id',
        ], [
            'numero_mesa.min' => 'El número de mesa debe ser al menos 1',
            'numero_mesa.max' => 'El número de mesa no puede ser mayor a 127',
            'numero_mesa.integer' => 'El número de mesa debe ser un número válido',
            'numero_mesa.required' => 'El número de mesa es obligatorio',
            'capacidad.min' => 'La capacidad debe ser de al menos 1 persona',
            'capacidad.max' => 'La capacidad no puede exceder las 127 personas',
            'capacidad.integer' => 'La capacidad debe ser un número válido',
            'capacidad.required' => 'La capacidad es obligatoria',
            'zona_id.required' => 'Debe seleccionar una zona',
            'zona_id.exists' => 'La zona seleccionada no existe'
        ]);

        //validar zona
        $zona = Zona::find($request->zona_id);

        if (!$zona) {
            return ApiResponse::error('La zona no pertenece a la cafetería',400);
        }

        //evitar duplicar número de mesa en la misma zona
        $existe = Mesa::where('zona_id', $request->zona_id)
            ->where('numero_mesa', $request->numero_mesa)
            ->where('id', '!=', $mesa->id)
            ->exists();

        if ($existe) {
            return ApiResponse::error('Ya existe una mesa con ese número en esta zona', 400);
        }

        $mesa->update([
            'numero_mesa'=>$request->numero_mesa,
            'capacidad'=>$request->capacidad,
            'zona_id'=>$request->zona_id,
        ]);

        return ApiResponse::success($mesa, 'Mesa actualizada correctamente');
    }

    /**
     * DESACTIVAR MESA
     */
    public function destroy(Request $request, Mesa $mesa)
    {
        $mesa->update([
            'activo'=>false,
        ]);

        return ApiResponse::success($mesa, 'Mesa desactivada correctamente');
    }

}
