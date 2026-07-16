<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Agrega el dominio actual a los dominios stateful de Sanctum
        // Asi funciona tanto en Railway como en local sin importar APP_URL
        if (!$this->app->runningInConsole() && $host = Request::getHost()) {
            $port = Request::getPort();
            $stateful = config('sanctum.stateful', []);
            $stateful[] = $host . ($port ? ':' . $port : '');
            config(['sanctum.stateful' => array_unique($stateful)]);
        }
    }
}
