<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QCController;
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


