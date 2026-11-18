<?php

use App\Http\Controllers\Autenticacao\CadastroController;
use App\Http\Controllers\Autenticacao\LoginController;
use App\Http\Controllers\Autenticacao\LogoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(CadastroController::class)->group(function () {
        Route::get('/cadastrar', 'formulario')->name('cadastrar');
        Route::post('/cadastrar', 'cadastrar');
    });

    Route::controller(LoginController::class)->group(function () {
        Route::get('/entrar', 'formulario')->name('entrar');
        Route::post('/entrar', 'entrar')->middleware('throttle:login');
    });
});

Route::post('/sair', LogoutController::class)->middleware('auth')->name('sair');
