<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GHController;

// buat route greenhouse
Route::prefix('greenhouse')->group(function () {
    // nampilin daftar greenhouse
    Route::get('/', [GHController::class, 'index'])->name('greenhouse.index');

    // detail greenhouse
    Route::get('/{id_greenhouse}', [GHController::class, 'show'])->name('detail_greenhouse');

    // update monitoring greenhouse
    Route::get('/update-monitoring/{id_greenhouse}', [GHController::class, 'FormUpdateMonitoring'])->name('monitoring_edit');
    Route::post('/update-monitoring/{id_greenhouse}', [GHController::class, 'updateMonitoring'])->name('monitoring_update');

    // update spesifikasi greenhouse
    Route::get('/update-spesifikasi/{id_greenhouse}', [GHController::class, 'FormUpdateSpesifikasi'])->name('spesifikasi_edit');
    Route::post('/update-spesifikasi/{id_greenhouse}', [GHController::class, 'updateSpesifikasi'])->name('spesifikasi_update');

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