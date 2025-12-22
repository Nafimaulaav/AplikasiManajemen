<?php
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// buat route laporan
Route::prefix('laporan')->group(function () {
    // nampilin daftar laporan
    Route::middleware('role:admin,petugas')->group(function(){
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // nambahin laporan harian + nyimpen data laporan harian baru
    Route::middleware('role:admin,petugas')->group(function(){
        Route::get('/tambah', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/tambah', [LaporanController::class, 'store'])->name('laporan.store');
    });

    // ngedit laporan harian
    Route::middleware('role:admin,petugas')->group(function(){
        Route::post('/edit/{id_laporanharian}', [LaporanController::class, 'update'])->name('laporan.update');
    });

});

// buat laporan harian khusus admin
Route::middleware('role:admin')->group(function(){
    Route::delete('/laporan/hapus/{id_laporanharian}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
});