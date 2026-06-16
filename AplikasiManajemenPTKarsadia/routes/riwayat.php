<?php

use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat.index');
});