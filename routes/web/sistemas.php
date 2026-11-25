<?php

use App\Http\Controllers\Sistema\SistemaController;
use Illuminate\Support\Facades\Route;

// Sistemas cadastrados
Route::prefix('sistemas')->name('sistemas.')->controller(SistemaController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{sistema:slug}', 'show')->name('show');
});
