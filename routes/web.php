<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\UmumController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\StaffController;
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
        Route::get('/lacak', [UmumController::class, 'lacak'])->name('lacak');
        // Route::get('/check-session', [UmumController::class, 'checkSession'])->name('check-session'); // <-- Jangan lupa dihapus kalau sudah mau di upload, HANYA UNTUK TESTING SESSION GOOGLE
        // Route::get('/email-test', [EmailController::class, 'kirimEmailStatus'])->name('email-test');
    });
// Umum End

// Pemohon Start
Route::middleware(['redirectIfNotAuthencicated', 'auth', 'role:pemohon'])
    ->prefix('/pemohon')
    ->name('pemohon.')
    ->group(function () {
        Route::get('/home', [PemohonController::class, 'home'])->name('home');
        Route::get('/agenda', [PemohonController::class, 'agenda'])->name('agenda');
        Route::get('/publikasi/liputan', [PemohonController::class, 'liputan'])->name('publikasi.liputan');
        Route::get('/publikasi/promosi', [PemohonController::class, 'promosi'])->name('publikasi.promosi');
        Route::get('/verifikasi-test', [PemohonController::class, 'verifikasiTest'])->name('verifikasi-test');

        // API
        Route::post('/api/get/sub-units', [ApiController::class, 'getSubUnits'])->name('api.get.sub-units');
        Route::post('/api/post/publikasi/liputan', [ApiController::class, 'postLiputan'])->name('api.post.publikasi');
        Route::post('/api/post/publikasi/promosi', [ApiController::class, 'postPromosi'])->name('api.post.promosi');
        Route::post('/api/delete/publikasi/', [ApiController::class, 'deletePublikasi'])->name('api.delete.publikasi');
        Route::post('/email/verifikasi-publikasi', [EmailController::class, 'verifikasiPublikasi'])->name('api.email.verifikasi-publikasi');
    });

Route::middleware(['redirectIfNotAuthencicated', 'role:pemohon'])
    ->prefix('/pemohon')
    ->name('pemohon.')
    ->group(function () {
        Route::get('/lacak', [PemohonController::class, 'lacak'])->name('lacak');
        Route::get('/verifikasi/{token}', [PemohonController::class, 'verifikasi'])->name('verifikasi');
    });
// Pemohon End

// Staff Start
Route::middleware(['redirectIfNotAuthencicated', 'auth', 'role:staff'])
    ->prefix('/staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/publikasi', [StaffController::class, 'home'])->name('home');
        Route::get('/riwayat', [StaffController::class, 'riwayat'])->name('riwayat');
        Route::GET('/riwayat/export', [ApiController::class, 'exportRiwayat'])->name('riwayat.export');
        Route::get('/riwayat/{id}', [StaffController::class, 'detailRiwayat'])->name('detail-riwayat');
        Route::get('/publikasi/detail/{id}', [StaffController::class, 'detailPublikasi'])->name('detail-publikasi');
        Route::get('/unit', [StaffController::class, 'unit'])->name('unit');
        Route::get('/unit/{id_unit}', [StaffController::class, 'subunit'])->name('unit.subUnit');

        //API Stuff
        Route::get('/api/get/unit', [ApiController::class, 'getUnit'])->name('api.get.unit');
        Route::post('/api/post/unit', [ApiController::class, 'postUnit'])->name('api.post.unit');
        Route::post('/api/post/sub-unit', [ApiController::class, 'postSubUnit'])->name('api.post.sub-unit');
        Route::post('/api/update/unit', [ApiController::class, 'updateUnit'])->name('api.update.unit');
        Route::post('/api/update/sub-unit', [ApiController::class, 'updateSubUnit'])->name('api.update.sub-unit');
        Route::post('/api/delete/unit', [ApiController::class, 'deleteUnit'])->name('api.delete.unit');
        Route::post('/api/delete/sub-unit', [ApiController::class, 'deleteSubUnit'])->name('api.delete.sub-unit');

        Route::get('/api/get/riwayat', [ApiController::class, 'getRiwayat'])->name('api.get.riwayat');
        Route::get('/api/get/publikasi', [ApiController::class, 'getPublikasi'])->name('api.get.publikasi');

        Route::post('/api/delete/publikasi/', [ApiController::class, 'deletePublikasi'])->name('api.delete.publikasi');
        Route::post('/api/update/status-publikasi/', [ApiController::class, 'updateStatusPublikasi'])->name('api.update.status-publikasi');
        Route::post('/api/update/link-output/', [ApiController::class, 'updateLinkOutput'])->name('api.update.link-output');
        Route::get('/api/get/file-promosi/{id}/{type}/{filename}', [FileController::class, 'getURLPromosi'])
            ->where('filename', '.*')
            ->name('api.get.file-promosi');
        Route::get('/api/get/file-liputan/{id}/{filename}', [FileController::class, 'getURLLiputan'])
            ->where('filename', '.*')
            ->name('api.get.file-liputan');

        // Thumbnail
        Route::get('/thumbnail/video/{id}/{type}/{filename}', [FileController::class, 'getVideoThumbnailTemp'])->name('api.get.video-thumbnail-temp');
    });
// Staff End

// API
Route::post('/api/get/jadwal-publikasi', [ApiController::class, 'getJadwalPublikasi'])->name('api.get.jadwal-publikasi');
Route::get('/api/get/tanggal-jadwal', [ApiController::class, 'getTanggalJadwal'])->name('api.get.tanggal-jadwal');

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
