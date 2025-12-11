<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TambahGreenhouseController;

// buat route login
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// buat route tambah greenhouse
Route::get('/greenhouse/tambah', [TambahGreenhouseController::class, 'FormCreateGH'])->name('tambah_greenhouse');
Route::post('/greenhouse/tambah', [TambahGreenhouseController::class, 'StoreGH'])->name('store_greenhouse');