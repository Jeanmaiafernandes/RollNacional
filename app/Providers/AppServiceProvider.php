<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Layouts em resources/views/layouts, usados como componentes: <x-layouts::app>, <x-layouts::visitante>.
        Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');

        // Usuário logado disponível no cabeçalho como $usuarios.
        View::composer('components.cabecalho', function ($view) {
            $view->with('usuarios', auth()->user());
        });

        // Limite de tentativas de login: 5 por minuto por e-mail + IP.
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(mb_strtolower((string) $request->input('email')).'|'.$request->ip());
        });
    }
}
