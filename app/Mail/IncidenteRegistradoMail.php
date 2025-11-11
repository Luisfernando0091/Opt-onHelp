<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidenteRegistradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $incidente;

    /**
     * Create a new message instance.
     */
    public function __construct($incidente)
    {
        $this->incidente = $incidente;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Registro de Incidente N° ' . $this->incidente->codigo)
                    ->view('emails.incidente-registrado');
    }
}
