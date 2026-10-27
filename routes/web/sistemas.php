<?php

use App\Http\Controllers\Sistema\SistemaJogoController;
use Illuminate\Support\Facades\Route;

Route::get('/sistemas', [SistemaJogoController::class, 'listar'])->name('sistemas.listar');
Route::get('/sistemas/{sistema}', [SistemaJogoController::class, 'exibir'])->name('sistemas.exibir');
