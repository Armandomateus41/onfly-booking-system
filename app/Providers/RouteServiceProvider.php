<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O caminho para a rota principal do aplicativo.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Configure as rotas do aplicativo.
     *
     * @return void
     */
    public function boot(): void
    {
        // Para depuração, você pode descomentar o próximo dd, mas faça isso somente para verificar se o método é chamado
        // dd('RouteServiceProvider boot called');

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
