<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// buat route login
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

