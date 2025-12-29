<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// // ===============================
// // READ (TAMPIL LAPORAN)
// // ===============================
// Route::get('/pendapatan', [TransaksiController::class, 'index'])
//     ->name('pendapatan');
// // ===============================
// // CREATE
// // ===============================
// Route::get('/pendapatan/tambah', [TransaksiController::class, 'create'])
//     ->name('transaksi.create');

// Route::post('/pendapatan/simpan', [TransaksiController::class, 'store'])
//     ->name('transaksi.store');
// // ===============================
// // UPDATE
// // ===============================
// Route::get('/pendapatan/{id}/edit', [TransaksiController::class, 'edit'])
//     ->name('transaksi.edit');

// Route::put('/pendapatan/{id}', [TransaksiController::class, 'update'])
//     ->name('transaksi.update');
// // ===============================
// // DELETE
// // ===============================
// Route::delete('/pendapatan/{id}', [TransaksiController::class, 'destroy'])
//     ->name('transaksi.destroy');

// ===============================
// ADMIN & PETUGAS
// ===============================
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/pendapatan', [TransaksiController::class, 'index'])
        ->name('pendapatan');

    Route::post('/pendapatan/simpan', [TransaksiController::class, 'store'])
        ->name('transaksi.store');
});

// ===============================
// ADMIN ONLY
// ===============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pendapatan/{id}/edit', [TransaksiController::class, 'edit'])
        ->name('transaksi.edit');

    Route::put('/pendapatan/{id}', [TransaksiController::class, 'update'])
        ->name('transaksi.update');

    Route::delete('/pendapatan/{id}', [TransaksiController::class, 'destroy'])
        ->name('transaksi.destroy');
});