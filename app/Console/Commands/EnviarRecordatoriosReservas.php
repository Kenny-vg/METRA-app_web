<?php

namespace App\Console\Commands;

use App\Models\Reservacion;
use App\Mail\RecordatorioReserva;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarRecordatoriosReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-recordatorios-reservas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía correos de recordatorio para las reservaciones (diario y 2 horas antes)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = now()->toDateString();
        $ahoraTime = now()->toTimeString();
        $dentroDe2HorasTime = now()->addHours(2)->toTimeString();

        // 1. RECORDATORIOS DIARIOS
        // Buscamos reservaciones para hoy que no han recibido el primer aviso
        /** @var \Illuminate\Database\Eloquent\Collection<int, Reservacion> $diarias */
        $diarias = Reservacion::where('fecha', $hoy)
            ->where('estado', Reservacion::STATUS_PENDIENTE)
            ->where('recordatorio_dia_enviado', false)
            ->whereNotNull('email')
            ->get();

        $this->info("Procesando " . $diarias->count() . " recordatorios diarios...");

        foreach ($diarias as $reserva) {
            /** @var Reservacion $reserva */
            try {
                Mail::to($reserva->email)->send(new RecordatorioReserva($reserva, 'diario'));
                $reserva->update(['recordatorio_dia_enviado' => true]);
                $this->line(" - Enviado (Diario): Folio {$reserva->folio} a {$reserva->email}");
            } catch (\Exception $e) {
                $this->error(" - Error enviando a {$reserva->email}: " . $e->getMessage());
            }
        }

        // 2. RECORDATORIOS 2 HORAS ANTES
        // Buscamos reservaciones de hoy que faltan < 2 horas y no han recibido este aviso
        // Nota: Solo se envían si la hora de inicio es mayor a la actual (obvio) y menor a ahora + 2h
        $proximas = Reservacion::where('fecha', $hoy)
            ->where('estado', Reservacion::STATUS_PENDIENTE)
            ->where('recordatorio_2h_enviado', false)
            ->whereNotNull('email')
            ->where('hora_inicio', '>=', $ahoraTime)
            ->where('hora_inicio', '<=', $dentroDe2HorasTime)
            ->get();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Reservacion> $proximas */
        $this->info("Procesando " . $proximas->count() . " recordatorios de 2 horas...");

        foreach ($proximas as $reserva) {
            /** @var Reservacion $reserva */
            try {
                Mail::to($reserva->email)->send(new RecordatorioReserva($reserva, '2horas'));
                $reserva->update(['recordatorio_2h_enviado' => true]);
                $this->line(" - Enviado (2h): Folio {$reserva->folio} a {$reserva->email}");
            } catch (\Exception $e) {
                $this->error(" - Error enviando a {$reserva->email}: " . $e->getMessage());
            }
        }

        $this->info("Finalizado el envío de recordatorios.");
    }
}
