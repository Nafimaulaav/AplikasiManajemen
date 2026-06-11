<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GHController;

Route::prefix('greenhouse')->middleware('auth')->group(function () {
    // Admin dan petugas dapat melihat serta menambahkan greenhouse.
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/', [GHController::class, 'index'])
            ->name('greenhouse.index');

        Route::post('/tambah', [GHController::class, 'StoreGreenhouse'])
            ->name('store_greenhouse');
    });

    // Perubahan data greenhouse hanya dapat dilakukan oleh admin.
    Route::middleware('role:admin')->group(function () {
        Route::post('/edit/{id_greenhouse}', [GHController::class, 'UpdateGreenhouse'])
            ->where('id_greenhouse', 'GH[0-9]+')
            ->name('update_greenhouse');

        Route::delete('/hapus/{id_greenhouse}', [GHController::class, 'DestroyGreenhouse'])
            ->where('id_greenhouse', 'GH[0-9]+')
            ->name('destroy_greenhouse');

        Route::post('/monitoring/edit/{id_greenhouse}', [GHController::class, 'updateMonitoring'])
            ->where('id_greenhouse', 'GH[0-9]+')
            ->name('update_monitoring');

        Route::post('/spesifikasi/edit/{id_greenhouse}', [GHController::class, 'updateSpecs'])
            ->where('id_greenhouse', 'GH[0-9]+')
            ->name('update_specs');
    });

    // Route dinamis ditempatkan paling bawah agar tidak menangkap URL statis.
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/{id_greenhouse}', [GHController::class, 'DetailGreenhouse'])
            ->where('id_greenhouse', 'GH[0-9]+')
            ->name('detail_greenhouse');
    });
});