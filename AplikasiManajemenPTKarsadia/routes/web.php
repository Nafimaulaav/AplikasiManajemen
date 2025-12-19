<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GHController;
use App\Http\Controllers\QCController;

// buat route login
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// buat route greenhouse
Route::prefix('greenhouse')->group(function () {
    // nambahin greenhouse + nyimpen data greenhouse baru
    Route::middleware('role:admin,petugas')->group(function(){
    Route::get('/tambah', [GHController::class, 'FormCreateGreenhouse'])->name('tambah_greenhouse');
    Route::post('/tambah', [GHController::class, 'StoreGreenhouse'])->name('store_greenhouse');
    });
    // ngedit  apus greenhouse
    Route::middleware('role:admin')->group(function(){
        Route::get('/edit/{id_greenhouse}', [GHController::class, 'FormEditGreenhouse'])->name('edit_greenhouse');
        Route::post('/edit/{id_greenhouse}', [GHController::class, 'UpdateGreenhouse'])->name('update_greenhouse');
        Route::delete('/hapus/{id_greenhouse}', [GHController::class, 'DestroyGreenhouse'])->name('destroy_greenhouse');
    });
});

// buat route qc
Route::prefix('qc')->group(function () {
    // nambahin QC
    Route::get('/tambah/{id_greenhouse}', [QCController::class, 'FormCreateQC'])->name('tambah_qc');
    // nyimpen data QC baru
    Route::post('/tambah', [QCController::class, 'StoreQC'])->name('store_qc');
    // ngedit QC
    Route::get('/edit/{id_log_qc}', [QCController::class, 'FormEditQC'])->name('edit_qc');
    Route::post('/edit/{id_log_qc}', [QCController::class, 'UpdateQC'])->name('update_qc');
    // ngehapus QC
    Route::delete('/hapus/{id_log_qc}', [QCController::class, 'DestroyQC'])->name('destroy_qc');
});