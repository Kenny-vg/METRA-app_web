<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Horario;
use App\Helpers\ApiResponse;
use App\Traits\Activable;

class HorarioController extends Controller
{
    use Activable;
    protected $model = Horario::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cafeId = $request->user()->cafe_id;

        $horarios = Horario::where('cafe_id', $cafeId)
        ->orderBy('dia_semana')
        ->get();

        return ApiResponse::success($horarios);
    }

    /**
     * CREAR HORARIO
     */
    public function store(Request $request)
    {
        $request->validate([
            'dia_semana' => 'required|in:Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo',
            'hora_apertura'=>'required|date_format:H:i',
            'hora_cierre'=>'required|date_format:H:i|after:hora_apertura',
        ]);

        if ($request->hora_cierre <= $request->hora_apertura) {
            return ApiResponse::error(
                'La hora de cierre debe ser mayor que la hora de apertura',
                400
            );
        }

        $cafeId = $request->user()->cafe_id;

        //evitar duplicar día
        $existe = Horario::where('cafe_id', $cafeId)
        ->where('dia_semana', $request->dia_semana)
        ->exists();

        if ($existe) {
            return ApiResponse::error('Ya existe un horario para ese día',400);
        }

        $horario = Horario::create([
            'dia_semana'=>$request->dia_semana,
            'hora_apertura'=>$request->hora_apertura,
            'hora_cierre'=>$request->hora_cierre,
            'cafe_id'=>$cafeId,
        ]);

        return ApiResponse::success($horario, 'Horario creado correctamente');
    }


    /**
     * ACTUALIZAR HORARIO
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hora_apertura'=>'required|date_format:H:i',
            'hora_cierre'=>'required|date_format:H:i|after:hora_apertura',
        ]);

        if ($request->hora_cierre <= $request->hora_apertura) {
            return ApiResponse::error(
                'La hora de cierre debe ser mayor que la hora de apertura',
                400
            );
        }

        $horario = Horario::where('id', $id)
        ->where('cafe_id', $request->user()->cafe_id)
        ->first();

        if (!$horario) {
            return ApiResponse::error('Horario no encontrado',404);
        }

        $horario->update([
            'hora_apertura'=>$request->hora_apertura,
            'hora_cierre'=>$request->hora_cierre,
        ]);

        return ApiResponse::success($horario, 'Horario actualizado correctamente');
    }

    /**
     * DESACTIVAR HORARIO
     */
    public function destroy(Request $request, $id)
    {
        $horario = Horario::where('id', $id)
        ->where('cafe_id', $request->user()->cafe_id)
        ->first();

        if (!$horario) {
            return ApiResponse::error('Horario no encontrado',404);
        }

        $horario->update([
            'activo'=>false,
        ]);

        return ApiResponse::success($horario, 'Horario desactivado correctamente');
    }

}
