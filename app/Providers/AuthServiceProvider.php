<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Adicione suas políticas aqui, se houver
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}