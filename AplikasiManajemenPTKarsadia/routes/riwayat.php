<?php

use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

// buat nampilin histori
Route::middleware('role:admin')->group(function() {
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});
