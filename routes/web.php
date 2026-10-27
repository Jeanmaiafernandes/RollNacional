<?php

use App\Http\Controllers\Campanha\CampanhaController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/autenticacao.php';

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', [CampanhaController::class, 'listar'])->name('inicio');

    foreach (glob(__DIR__ . '/web/*.php') as $arquivo) {
        require $arquivo;
    }
});

Route::fallback(fn () => redirect()->route('inicio'));
