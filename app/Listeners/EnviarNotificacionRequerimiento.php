<?php

namespace App\Listeners;

use App\Events\Requerimientocreado;

class EnviarNotificacionRequerimiento
{
    public function handle(Requerimientocreado $event)
    {
        $requerimiento = $event->requerimiento;

        // Aquí envías la notificación por Firebase, Email, etc.
        // Ejemplo simple:
        \Log::info("Nuevo requerimiento creado: " . $requerimiento->titulo);
    }
}
