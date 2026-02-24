<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Models\Cafeteria;
use App\Helpers\ApiResponse;
use Carbon\Carbon;



class SuscripcionController extends Controller
{
    /**
     * LISTA DE SUSCRIPCIONES.
     */
    public function index()
    {
        return ApiResponse::success(
            Suscripcion::with(['cafeteria', 'plan'])->get(),
        'Listado de Suscripciones'
        );
        
    }

    /**
     * CREAR SUSCRIPCION.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cafe_id'=>'required|exists:cafeterias,id',
            'plan_id'=>'required|exists:planes,id',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        //no permitir planes inactivos
        if(!$plan->estado){
            return ApiResponse::error(
                'El plan seleccionado no esta activo',
                400
            );
        } 

        // evitar doble suscripción activa
        $existente = Suscripcion::where('cafe_id',$data['cafe_id'])
            ->where('fecha_fin','>',now())
            ->first();

        if($existente){
            return ApiResponse::error(
                'La cafetería ya tiene una suscripción activa',
                400
            );
        }
                
        $fecha_inicio=Carbon::now();
        $fecha_fin=(clone $fecha_inicio)->addDays($plan->duracion_dias);

        $suscripcion = Suscripcion::create([
            'cafe_id'=>$data['cafe_id'],
            'plan_id'=>$data['plan_id'],
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'estado'=>true,
            'monto'=>$plan->precio,
        ]);

        $suscripcion->load(['cafeteria', 'plan']);

        return ApiResponse::success(
            $suscripcion,
            'Suscripcion creada correctamente'
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Suscripcion $suscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suscripcion $suscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suscripcion $suscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suscripcion $suscripcion)
    {
        //
    }
}
