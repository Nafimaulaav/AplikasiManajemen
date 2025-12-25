<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanenController;

// ======================
// PANEN ROUTES
// ======================

// index
Route::get('/panen', [PanenController::class, 'index'])
    ->name('panen.index');

// form tambah
Route::get('/panen/tambah', [PanenController::class, 'FormCreatePanen'])
    ->name('tambah_panen');

// simpan data baru
Route::post('/panen/tambah', [PanenController::class, 'StorePanen'])
    ->name('store_panen');

// form edit
Route::get('/panen/edit/{id_panen}', [PanenController::class, 'FormEditPanen'])
    ->name('edit_panen');

// update data
Route::put('/panen/edit/{id_panen}', [PanenController::class, 'UpdatePanen'])
    ->name('update_panen');

// hapus data
Route::delete('/panen/hapus/{id_panen}', [PanenController::class, 'DestroyPanen'])
    ->name('destroy_panen');

// detail
Route::get('/panen/{id_panen}', [PanenController::class, 'show'])
    ->name('detail_panen');

// Atau gunkan resource untuk route yang lebih clean:
// Route::resource('panen', PanenController::class);