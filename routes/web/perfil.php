<?php

use App\Http\Controllers\Usuario\PerfilController;
use Illuminate\Support\Facades\Route;

Route::get('/perfil', [PerfilController::class, 'exibir'])->name('perfil');
Route::put('/perfil', [PerfilController::class, 'atualizar'])->name('perfil.atualizar');
Route::put('/perfil/senha', [PerfilController::class, 'atualizarSenha'])->name('perfil.senha.atualizar');
