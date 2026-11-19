<?php

use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;

// Perfil público: /usuarios/{nome_usuario}
Route::get('/usuarios/{usuario:nome_usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
