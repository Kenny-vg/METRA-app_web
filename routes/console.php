<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

Schedule::call(function () {

    //Marcar reservaciones pendientes como no show si ya pasaron más de 20 minutos de la hora de inicio
    DB::table('reservaciones')
        ->where('estado', 'pendiente')
        ->whereRaw("
            TIMESTAMP(fecha, hora_inicio) < NOW() - INTERVAL 20 MINUTE
        ")
        ->update([
        'estado' => 'no_show'
    ]);

})->everyMinute();