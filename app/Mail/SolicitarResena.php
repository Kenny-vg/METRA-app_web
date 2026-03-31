<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitarResena extends Mailable
{
    use Queueable, SerializesModels;

    public $ocupacion;
    public $url;

    public function __construct($ocupacion)
    {
        $this->ocupacion = $ocupacion;

        $this->url = url('/resena/' . $ocupacion->token_resena);
    }

    public function build()
    {
        return $this->subject('Cuéntanos tu experiencia en METRA')
            ->view('emails.solicitar-resena')
            ->with([
            'nombre' => $this->ocupacion->nombre_cliente ?? ($this->ocupacion->reservacion->nombre_cliente ?? 'Cliente'),
            'url' => $this->url
        ]);
    }
}