<?php

use App\Http\Controllers\Autenticacao\CadastroController;
use App\Http\Controllers\Autenticacao\LoginController;
use App\Http\Controllers\Autenticacao\LogoutController;

Route::middleware('guest')->group(function () {
    Route::controller(CadastroController::class)->group(function () {
        Route::get('/registrar', 'formulario')->name('registrar');
        Route::post('/registrar', 'cadastrar');
    });

    Route::controller(LoginController::class)->group(function () {
        Route::get('/entrar', 'formulario')->name('entrar');
        Route::post('/entrar', 'entrar')->middleware('throttle:login');
    });
});

Route::post('/sair', LogoutController::class)->middleware('auth')->name('sair');

