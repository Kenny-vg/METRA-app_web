<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

// Usa el comando de Artisan para evitar desfases de zona horaria entre MySQL y PHP
Schedule::command('app:marcar-reservaciones-no-show')->everyMinute();

// Refresco diario de la Vista Materializada simulada (Métricas mensuales)
Schedule::call(fn() => DB::unprepared('CALL sp_refresh_mv_metricas_mensuales()'))
    ->dailyAt('00:00')
    ->name('refresh-materialized-metrics');

// Recordatorios de reservaciones (Diario y 2 Horas)
Schedule::command('app:enviar-recordatorios-reservas')->everyFifteenMinutes();