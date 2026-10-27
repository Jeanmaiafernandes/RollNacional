<?php

use App\Http\Controllers\Mesa\ItemBibliotecaController;
use App\Http\Controllers\Mesa\MesaController;
use Illuminate\Support\Facades\Route;

// Tudo aqui acontece dentro de uma campanha: /campanhas/{campanha}/...
Route::prefix('campanhas/{campanha}')
    ->where(['campanha' => '[0-9]+', 'item' => '[0-9]+'])
    ->group(function () {
        Route::get('/mesa', [MesaController::class, 'exibir'])->name('mesa.exibir');

        Route::post('/biblioteca', [ItemBibliotecaController::class, 'salvar'])->name('biblioteca.salvar');
        Route::get('/biblioteca/{item}', [ItemBibliotecaController::class, 'exibir'])->name('biblioteca.exibir');
        Route::put('/biblioteca/{item}', [ItemBibliotecaController::class, 'atualizar'])->name('biblioteca.atualizar');
        Route::delete('/biblioteca/{item}', [ItemBibliotecaController::class, 'excluir'])->name('biblioteca.excluir');
    });
