<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TambahGreenhouseController;
use App\Http\Controllers\TambahQCController;

// buat route login
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// buat route tambah greenhouse
Route::get('/greenhouse/tambah', [TambahGreenhouseController::class, 'FormCreateGH'])->name('tambah_greenhouse');
Route::post('/greenhouse/tambah', [TambahGreenhouseController::class, 'StoreGH'])->name('store_greenhouse');

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