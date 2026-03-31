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
        // Marcar reservaciones pendientes como no show si ya pasaron los minutos de tolerancia
        Reservacion::with('cafeteria')
            ->where('estado', Reservacion::STATUS_PENDIENTE)
            ->get()
            ->each(function ($reservacion) {

            $tolerancia = $reservacion->cafeteria->tolerancia_reserva_min ?? 15;
            
            $horaLimite = Carbon::parse(
                $reservacion->fecha . ' ' . $reservacion->hora_inicio
            )->addMinutes($tolerancia);

            if (now()->greaterThan($horaLimite)) {
                $reservacion->update([
                    'estado' => Reservacion::STATUS_NOSHOW
                ]);

                // Notificar al cliente
                if ($reservacion->email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($reservacion->email)
                            ->send(new \App\Mail\ReservaNoShow($reservacion));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Error enviando correo de No-Show (ID: {$reservacion->id}): " . $e->getMessage());
                    }
                }
            }
        });

        return 0;
    }
}
