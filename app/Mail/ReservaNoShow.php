<?php

namespace App\Mail;

use App\Models\Reservacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaNoShow extends Mailable
{
    use Queueable, SerializesModels;

    public $reservacion;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservacion $reservacion)
    {
        $this->reservacion = $reservacion;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $nombreCafe = $this->reservacion->cafeteria ? $this->reservacion->cafeteria->nombre : 'la cafetería';

        return $this->subject("Información sobre tu reservación en {$nombreCafe}")
                    ->view('emails.reserva-noshow');
    }
}
