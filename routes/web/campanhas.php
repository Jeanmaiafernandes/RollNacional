<?php

use App\Http\Controllers\Campanha\CampanhaController;
use App\Http\Controllers\Campanha\EntrarNaCampanhaController;
use App\Http\Controllers\Campanha\ParticipanteController;
use App\Http\Controllers\Campanha\SairDaCampanhaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampanhaController::class, 'listar'])->name('inicio');

Route::post('/campanhas/entrar', EntrarNaCampanhaController::class)
    ->middleware('throttle:5,1')
    ->name('campanhas.entrar');

Route::get('/campanhas/criar', [CampanhaController::class, 'criar'])->name('campanhas.criar');
Route::post('/campanhas', [CampanhaController::class, 'salvar'])->name('campanhas.salvar');
Route::get('/campanhas/{campanha}', [CampanhaController::class, 'exibir'])->name('campanhas.exibir');
Route::get('/campanhas/{campanha}/editar', [CampanhaController::class, 'editar'])->name('campanhas.editar');
Route::put('/campanhas/{campanha}', [CampanhaController::class, 'atualizar'])->name('campanhas.atualizar');
Route::delete('/campanhas/{campanha}', [CampanhaController::class, 'excluir'])->name('campanhas.excluir');

Route::post('/campanhas/{campanha}/sair', SairDaCampanhaController::class)->name('campanhas.sair');

Route::patch('/campanhas/{campanha}/participantes/{usuarios}', [ParticipanteController::class, 'atualizar'])
    ->name('campanhas.participantes.atualizar');
Route::delete('/campanhas/{campanha}/participantes/{usuarios}', [ParticipanteController::class, 'expulsar'])
    ->name('campanhas.participantes.expulsar');
