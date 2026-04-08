<?php

namespace App\Mail;

use App\Models\Reservacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecordatorioReserva extends Mailable
{
    use Queueable, SerializesModels;

    public Reservacion $reservacion;
    public string $tipo; // 'diario' o '2horas'

    /**
     * Create a new message instance.
     */
    public function __construct(Reservacion $reservacion, string $tipo)
    {
        $this->reservacion = $reservacion;
        $this->tipo = $tipo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = ($this->tipo === 'diario') 
            ? '¡Hoy es el día de tu reserva! – METRA'
            : 'Tu reserva es en 2 horas – METRA';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.recordatorio',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
