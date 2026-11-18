<?php

use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/autenticacao.php';

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', PainelController::class)->name('inicio');

    foreach (glob(__DIR__.'/web/*.php') as $arquivo) {
        require $arquivo;
    }
});

Route::fallback(fn () => redirect()->route('inicio'));
