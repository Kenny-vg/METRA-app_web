<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

// Usa el comando de Artisan para evitar desfases de zona horaria entre MySQL y PHP
Schedule::command('app:marcar-reservaciones-no-show')->everyMinute();