<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UmumController;
use Illuminate\Support\Facades\Route;

// Web Routes
// Umum Start
Route::get('/', [UmumController::class, 'homepage'])->name('homepage');
// Umum End

// Mahasiswa Start
Route::get('/mahasiswa', [MahasiswaController::class, 'home'])->name('mahasiswa.home');


// API
// Route::get('auth/google/callback', [AccountController::class, 'handleProvidersCallback'])->name('google.callback');
Route::post('/auth/google/callback', [AccountController::class, 'googleLogin'])->name('google.callback');
