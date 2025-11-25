<?php

namespace App\Events;

use App\Models\Requerimiento;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Requerimientocreado
{
    use Dispatchable, SerializesModels;

    public $requerimiento;

    public function __construct(Requerimiento $incidente)
    {
        $this->requerimiento = $incidente;
    }
}
