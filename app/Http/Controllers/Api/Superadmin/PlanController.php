<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Helpers\ApiResponse;

class PlanController extends Controller
{
    //Listar planes
    public function index()
    {
        return ApiResponse::success(
            Plan::all(),
            'Listado de Planes'
        );
    }

    //Crear plan
    public function store(Request $request, Plan $plan)
    {
        $data=$request->validate([
            'nombre_plan'=>'required|unique:planes',
            'precio'=>'required|numeric|min:0',
            'max_reservas_mes'=>'required|integer|min:1',
            'max_usuarios_admin'=>'required|integer|min:1',
            'duracion_dias'=>'required|integer|min:1',
            'descripcion'=>'nullable|string|max:255',
        ]);

        $data['estado']=true;

        $plan = Plan::create($data);
        return ApiResponse::success($plan,'Plan Creado Correctamente');

    }


    //Actualizar plan
    public function update(Request $request, Plan $plan)
    {
        $data=$request->validate([
            'nombre_plan'=>'sometimes|string|unique:planes,nombre_plan,'.$plan->id,
            'precio'=>'sometimes|numeric|min:0',
            'max_reservas_mes'=>'sometimes|integer|min:1',
            'max_usuarios_admin'=>'sometimes|integer|min:1',
            'duracion_dias'=>'sometimes|integer|min:1',
            'descripcion'=>'nullable|string|max:255',
            'estado'=>'sometimes|boolean',
        ]);

        $plan->update($data);
        return ApiResponse::success(
            $plan,
            'Plan actualizado correctamente'
        );
    }

    //Eliminar plan
    public function destroy (Plan $plan)
    {
        $plan->update([
        'estado' => false
    ]);

    return ApiResponse::success(
        $plan,
        'Plan desactivado correctamente'
    );
    }

}
