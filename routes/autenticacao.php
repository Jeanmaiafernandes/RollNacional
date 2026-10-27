<?php

use App\Http\Controllers\Autenticacao\CadastroController;
use App\Http\Controllers\Autenticacao\LoginController;
use App\Http\Controllers\Autenticacao\LogoutController;
use Illuminate\Support\Facades\Route;

Route::name('autenticacao.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'formulario'])->name('login');
        Route::post('/login', [LoginController::class, 'entrar'])
            ->middleware('throttle:5,1')
            ->name('entrar.enviar');

        Route::get('/cadastro', [CadastroController::class, 'formulario'])->name('cadastro');
        Route::post('/cadastro', [CadastroController::class, 'cadastrar'])
            ->middleware('throttle:5,1')
            ->name('cadastro.enviar');
    });

    Route::post('/sair', LogoutController::class)
        ->middleware('auth')
        ->name('sair');
});
