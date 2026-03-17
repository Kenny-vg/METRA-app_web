<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservacion;
use Carbon\Carbon;

class MarcarReservacionesNoShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:marcar-reservaciones-no-show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Marcar reservaciones pendientes como no show si ya pasaron más de 20 minutos de la hora de inicio
        Reservacion::where('estado', 'pendiente')
            ->get()
            ->each(function ($reservacion) {

            $hora = Carbon::parse(
                $reservacion->fecha . ' ' . $reservacion->hora_inicio
            )->addMinutes(20);

            if (now()->greaterThan($hora)) {
                $reservacion->update([
                    'estado' => 'no_show'
                ]);
            }
        });

        return 0;
    }
}
