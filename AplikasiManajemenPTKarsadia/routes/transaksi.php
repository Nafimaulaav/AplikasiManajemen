<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// Admin dan petugas dapat melihat dan menambahkan transaksi.
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/pendapatan', [TransaksiController::class, 'index'])
        ->name('pendapatan');

    Route::post('/pendapatan/simpan', [TransaksiController::class, 'store'])
        ->name('transaksi.store');
});

// Form edit berada di modal halaman pendapatan.
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::put('/pendapatan/{id}', [TransaksiController::class, 'update'])
        ->name('transaksi.update');

    Route::delete('/pendapatan/{id}', [TransaksiController::class, 'destroy'])
        ->where('id', 'TR[0-9]+')
        ->name('transaksi.destroy');
});