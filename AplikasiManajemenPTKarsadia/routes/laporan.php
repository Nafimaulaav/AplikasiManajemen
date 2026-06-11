<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::prefix('laporan')->middleware('auth')->group(function () {
    // Admin dan petugas dapat melihat dan menambahkan laporan.
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])
            ->name('laporan.index');

        // Form tambah berada di modal halaman daftar laporan.
        Route::post('/tambah', [LaporanController::class, 'store'])
            ->name('laporan.store');
    });

    // Form edit juga berada di modal halaman daftar laporan.
    Route::middleware('role:admin')->group(function () {
        Route::post('/edit/{id_laporanharian}', [LaporanController::class, 'update'])
            ->where('id_laporanharian', 'LP[0-9]+')
            ->name('laporan.update');

        Route::delete('/hapus/{id_laporanharian}', [LaporanController::class, 'destroy'])
            ->where('id_laporanharian', 'LP[0-9]+')
            ->name('laporan.destroy');
    });
});