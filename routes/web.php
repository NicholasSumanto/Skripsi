<?php

use App\Http\Controllers\AccountController;
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
    });
// Umum End

// Pemohon Start
Route::middleware(['auth', 'role:pemohon'])
    ->prefix('/pemohon')
    ->name('pemohon.')
    ->group(function () {
        Route::get('/home', [PemohonController::class, 'home'])->name('home');
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

Route::get('/check-session', function () {
    return response()->json([
        'auth_user' => Auth::user(),
        'session_id' => session()->getId(),
    ]);
})->name('check-session');

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
