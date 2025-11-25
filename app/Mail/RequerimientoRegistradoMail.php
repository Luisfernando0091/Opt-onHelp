<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequerimientoRegistradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requerimiento;

    public function __construct($requerimiento)
    {
        $this->requerimiento = $requerimiento;
    }

    public function build()
    {
        return $this->subject('Nuevo requerimiento registrado - OpcionHelp')
                    ->view('emails.incidente-registrado')
                    ->with([
                        'incidente' => $this->requerimiento,
                    ]);
    }
}
