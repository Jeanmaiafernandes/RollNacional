<?php

use App\Http\Controllers\Usuario\PerfilController;
use Illuminate\Support\Facades\Route;

Route::prefix('conta')->name('conta.')->group(function () {
    Route::controller(PerfilController::class)->group(function () {
        Route::get('/', 'perfil');
        Route::patch('/', 'atualizarPerfil')->name('atualizar');
        Route::patch('/senha', 'atualizarSenha')->name('senha');});
});
