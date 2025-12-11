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

// buat route tambah qc
Route::get('/greenhouse/{id_greenhouse}/qc/tambah', [TambahQCController::class, 'FormTambahQC'])->name('tambah_qc');
Route::post('/qc/tambah', [TambahQCController::class, 'StoreQC'])->name('store_qc');
