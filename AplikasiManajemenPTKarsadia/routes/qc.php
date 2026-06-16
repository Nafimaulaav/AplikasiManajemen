<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QCController;

Route::prefix('qc')->middleware(['auth', 'role:admin,petugas'])->group(function () {
    // Form tambah dan edit QC berada di modal halaman detail greenhouse.
    Route::post('/tambah', [QCController::class, 'store'])
        ->name('store_qc');

    Route::post('/edit/{id_log_qc}', [QCController::class, 'update'])
        ->whereNumber('id_log_qc')
        ->name('update_qc');

    Route::delete('/hapus/{id_log_qc}', [QCController::class, 'destroy'])
        ->whereNumber('id_log_qc')
        ->name('destroy_qc');
});