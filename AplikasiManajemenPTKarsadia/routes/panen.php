<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanenController;

// // ======================
// // PANEN ROUTES
// // ======================

// // index
// Route::get('/panen', [PanenController::class, 'index'])
//     ->name('panen.index');

// // form tambah
// Route::get('/panen/tambah', [PanenController::class, 'FormCreatePanen'])
//     ->name('tambah_panen');

// // simpan data baru
// Route::post('/panen/tambah', [PanenController::class, 'StorePanen'])
//     ->name('store_panen');

// // form edit
// Route::get('/panen/edit/{id_panen}', [PanenController::class, 'FormEditPanen'])
//     ->name('edit_panen');

// // update data
// Route::put('/panen/edit/{id_panen}', [PanenController::class, 'UpdatePanen'])
//     ->name('update_panen');

// // hapus data
// Route::delete('/panen/hapus/{id_panen}', [PanenController::class, 'DestroyPanen'])
//     ->name('destroy_panen');

// // detail
// Route::get('/panen/{id_panen}', [PanenController::class, 'show'])
//     ->name('detail_panen');

// Atau gunkan resource untuk route yang lebih clean:
// Route::resource('panen', PanenController::class);

// ===============================
// ADMIN & PETUGAS
// ===============================
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    Route::get('/panen', [PanenController::class, 'index'])
        ->name('panen.index');

    Route::get('/panen/{id_panen}', [PanenController::class, 'show'])
        ->name('detail_panen');

    Route::post('/panen/tambah', [PanenController::class, 'StorePanen'])
        ->name('store_panen');
});

// ===============================
// ADMIN ONLY
// ===============================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/panen/tambah', [PanenController::class, 'FormCreatePanen'])
        ->name('tambah_panen');

    Route::get('/panen/edit/{id_panen}', [PanenController::class, 'FormEditPanen'])
        ->name('edit_panen');

    Route::put('/panen/edit/{id_panen}', [PanenController::class, 'UpdatePanen'])
        ->name('update_panen');

    Route::delete('/panen/hapus/{id_panen}', [PanenController::class, 'DestroyPanen'])
        ->name('destroy_panen');
});
