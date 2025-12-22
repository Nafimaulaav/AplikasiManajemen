<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// buat route login
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/profile', [LoginController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



