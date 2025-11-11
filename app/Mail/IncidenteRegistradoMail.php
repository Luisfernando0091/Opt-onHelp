<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidenteRegistradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $incidente;

    public function __construct($incidente)
    {
        $this->incidente = $incidente;
    }

    public function build()
    {
        return $this->subject('Nuevo incidente registrado - OpcionHelp')
                    ->view('emails.incidente-registrado')
                    ->with([
                        'incidente' => $this->incidente,
                    ]);
    }
}
