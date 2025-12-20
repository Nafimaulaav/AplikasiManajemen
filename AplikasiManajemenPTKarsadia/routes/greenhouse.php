<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GHController;

// buat route greenhouse
Route::prefix('greenhouse')->group(function () {
    
    
    // nampilin daftar greenhous detail greenhouse
    Route::middleware('role:admin,petugas')->group(function(){
    Route::get('/', [GHController::class, 'index'])->name('greenhouse.index');
    Route::get('/{id_greenhouse}', [GHController::class, 'DetailGreenhouse'])->name('detail_greenhouse');
    });

    


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