<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanenController;

// Admin dan petugas dapat melihat dan menambahkan data panen.
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/panen', [PanenController::class, 'index'])
        ->name('panen.index');

    // Form tambah berada di modal halaman panen.
    Route::post('/panen/tambah', [PanenController::class, 'StorePanen'])
        ->name('store_panen');
});

// Perubahan dan penghapusan data panen hanya dapat dilakukan oleh admin.
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/panen/edit/{id_panen}', [PanenController::class, 'UpdatePanen'])
        ->where('id_panen', 'PN[0-9]+')
        ->name('update_panen');

    Route::post('/panen/hapus/{id_panen}', [PanenController::class, 'DestroyPanen'])
        ->where('id_panen', 'PN[0-9]+')
        ->name('destroy_panen');
});