<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobanteRechazado extends Mailable
{
    use Queueable, SerializesModels;

    public string $nombreCafeteria;

    public function __construct(string $nombreCafeteria)
    {
        $this->nombreCafeteria = $nombreCafeteria;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'METRA — Tu comprobante de pago fue rechazado',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante-rechazado',
        );
    }
}
