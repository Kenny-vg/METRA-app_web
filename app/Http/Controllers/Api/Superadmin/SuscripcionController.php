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

    if(!$plan->estado){
        return ApiResponse::error(
            'El plan seleccionado ya no está activo',
            400
        );
    }

    $activa = Suscripcion::where('cafe_id', $data['cafe_id'])
        ->where('fecha_fin','>',now())
        ->latest('fecha_fin')
        ->first();

    $futura = Suscripcion::where('cafe_id',$data['cafe_id'])
        ->where('fecha_inicio','>',now())
        ->exists();

    if($futura){
        return ApiResponse::error(
            'Ya existe una renovación pendiente',
            400
        );
    }

    $fecha_inicio = $activa
        ? Carbon::parse($activa->fecha_fin)
        : now();

    $fecha_fin = (clone $fecha_inicio)
        ->addDays($plan->duracion_dias);

    $suscripcion = Suscripcion::create([
        'cafe_id'=>$data['cafe_id'],
        'plan_id'=>$data['plan_id'],
        'fecha_inicio'=>$fecha_inicio,
        'fecha_fin'=>$fecha_fin,
        'estado_pago'=>'pendiente',
        'monto'=>$plan->precio,
    ]);

    $suscripcion->load(['cafeteria','plan']);

    return ApiResponse::success(
        $suscripcion,
        'Suscripción creada correctamente'
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
