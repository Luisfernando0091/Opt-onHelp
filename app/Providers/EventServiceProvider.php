<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\IncidenteCreado::class => [
            \App\Listeners\EnviarNotificacionIncidente::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
