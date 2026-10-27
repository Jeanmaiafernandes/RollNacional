<?php

use App\Http\Controllers\Personagem\PersonagemController;
use Illuminate\Support\Facades\Route;

Route::get('/personagens', [PersonagemController::class, 'listar'])->name('personagens.listar');
Route::get('/personagens/criar', [PersonagemController::class, 'criar'])->name('personagens.criar');
Route::post('/personagens', [PersonagemController::class, 'salvar'])->name('personagens.salvar');
Route::get('/personagens/{personagem}', [PersonagemController::class, 'exibir'])->name('personagens.exibir');
Route::put('/personagens/{personagem}', [PersonagemController::class, 'atualizar'])->name('personagens.atualizar');
Route::delete('/personagens/{personagem}', [PersonagemController::class, 'excluir'])->name('personagens.excluir');
