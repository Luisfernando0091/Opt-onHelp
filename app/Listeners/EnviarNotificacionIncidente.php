<?php

namespace App\Listeners;

use App\Events\IncidenteCreado;
use App\Services\FirebaseService;
use App\Models\UserToken;

class EnviarNotificacionIncidente
{
    public function handle(IncidenteCreado $event)
    {
        $firebase = new FirebaseService();

        $tokens = UserToken::pluck('token')->toArray();

        foreach ($tokens as $token) {
            $firebase->sendNotification(
                $token,
                'Nuevo Incidente',
                $event->incidente->titulo,
                ['incidente_id' => $event->incidente->id]
            );
        }
    }
}
