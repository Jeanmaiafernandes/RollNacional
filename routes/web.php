<?php

use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/autenticacao.php';

// Página inicial pública. Quem já está logado vai direto para o painel.
Route::get('/', function () {
    return auth()->check() ? redirect()->route('inicio') : view('publico.inicio');
})->name('pagina-inicial');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/inicio', PainelController::class)->name('inicio');

    foreach (glob(__DIR__.'/web/*.php') as $arquivo) {
        require $arquivo;
    }
});

Route::fallback(fn () => redirect()->route('pagina-inicial'));
