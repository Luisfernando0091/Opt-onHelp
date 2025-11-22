<?php

namespace App\Events;

use App\Models\Incidente;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncidenteCreado
{
    use Dispatchable, SerializesModels;

    public $incidente;

    public function __construct(Incidente $incidente)
    {
        $this->incidente = $incidente;
    }
}
