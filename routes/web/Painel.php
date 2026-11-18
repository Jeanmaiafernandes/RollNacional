<?php

use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

Route::post('painel', [PainelController::class, '__invoke'])->name('painel');
