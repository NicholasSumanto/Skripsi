<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('umum.home');
});


// API
// Route::get('auth/google/callback', [AccountController::class, 'handleProvidersCallback'])->name('google.callback');
Route::post('/auth/google/callback', [AccountController::class, 'googleLogin'])->name('google.callback');
