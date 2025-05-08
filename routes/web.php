<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\UmumController;
use Illuminate\Support\Facades\Route;

// Web Routes
// Umum Start
Route::middleware(['redirectIfAuthenticated', 'guest'])
    ->prefix('/')
    ->name('umum.')
    ->group(function () {
        Route::get('/', [UmumController::class, 'home'])->name('home');
        Route::get('/unduhan', [UmumController::class, 'unduhan'])->name('unduhan');
        Route::get('/verifikasi/{token}', [UmumController::class, 'verifikasi'])->name('verifikasi');
        Route::get('/verifikasi-halaman', [UmumController::class, 'verifikasiHalaman'])->name('verifikasi-halaman');
        Route::get('/check-session', [UmumController::class, 'checkSession'])->name('check-session'); // <-- Jangan Lupa Dimatikan kalau sudah mau di upload, HANYA UNTUK TESTING SESSION GOOGLE
    });
// Umum End

// Pemohon Start
Route::middleware(['auth', 'role:pemohon'])
    ->prefix('/pemohon')
    ->name('pemohon.')
    ->group(function () {
        Route::get('/home', [PemohonController::class, 'home'])->name('home');
        Route::get('/agenda', [PemohonController::class, 'agenda'])->name('agenda');
        Route::get('/verifikasi-test', [PemohonController::class, 'verifikasiTest'])->name('verifikasi-test');
        Route::get('/verifikasi/{token}', [PemohonController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/email/verifikasi-publikasi', [EmailController::class, 'verifikasiPublikasi'])->name('email.verifikasi-publikasi');

    });

Route::prefix('umum/pemohon')
    ->name('umum.pemohon.')
    ->group(function () {
        Route::get('/home', [PemohonController::class, 'home'])->name('home');
        Route::get('/agenda', [PemohonController::class, 'agenda'])->name('agenda');
    });
// Pemohon End

// Staff Start
Route::middleware(['auth', 'role:staff'])
    ->prefix('/staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/home', [PemohonController::class, 'home'])->name('home');
    });
// Pemohon End


// API
// Route::get('auth/google/callback', [AccountController::class, 'handleProvidersCallback'])->name('google.callback');
Route::middleware('guest')
    ->prefix('/auth')
    ->group(function () {
        Route::post('/google/callback', [AccountController::class, 'callback'])->name('google.callback');
    });
Route::middleware('auth')
    ->prefix('/auth')
    ->group(function () {
        Route::post('/google/destroy', [AccountController::class, 'logout'])->name('google.logout');
    });
