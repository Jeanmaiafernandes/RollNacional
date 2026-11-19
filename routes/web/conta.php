<?php

use App\Http\Controllers\Usuario\EditarPerfilController;
use App\Http\Controllers\Usuario\PerfilController;
use Illuminate\Support\Facades\Route;

Route::prefix('conta')->name('conta.')->group(function () {
    // Dados da conta e senha
    Route::controller(PerfilController::class)->group(function () {
        Route::get('/', 'dados')->name('dados');
        Route::put('/', 'atualizarEmail')->name('email');
        Route::get('/senha', 'senha')->name('senha');
        Route::put('/senha', 'atualizarSenha')->name('senha.atualizar');
    });

    // Perfil público: foto, nome, apresentação
    Route::controller(EditarPerfilController::class)->group(function () {
        Route::get('/perfil', 'editar')->name('perfil');
        Route::put('/perfil', 'atualizar')->name('perfil.atualizar');
    });
});
