<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Adicione seus ouvintes de eventos aqui, se houver
    ];

    public function boot()
    {
        //
    }
}