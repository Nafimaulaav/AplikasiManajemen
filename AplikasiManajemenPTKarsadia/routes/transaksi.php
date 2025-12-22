<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

Route::get('/pendapatan', [TransaksiController::class, 'index'])
    ->name('pendapatan');
