<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanSuratController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\MasterSuratController;
use App\Http\Controllers\SuratPublicController;

// =============================================
// PUBLIC ROUTES (No Auth)
// =============================================
Route::get('/', fn() => redirect()->route('login'));
Route::get('/surat/verify/{qr_code}', [SuratPublicController::class, 'verify'])->name('surat.verify');

Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);

Route::get('/register',         [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',        [AuthController::class, 'register']);
Route::get('/register/pending', [AuthController::class, 'registerPending'])->name('register.pending');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================================
// PROTECTED ROUTES (Auth Required)
// =============================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- WARGA ---
    Route::prefix('warga')->name('warga.')->group(function () {
        Route::get('/permohonan/create',           [PermohonanSuratController::class, 'create'])->name('permohonan.create');
        Route::get('/permohonan/form/{id}',        [PermohonanSuratController::class, 'form'])->name('permohonan.form');
        Route::post('/permohonan/store',           [PermohonanSuratController::class, 'store'])->name('permohonan.store');
        Route::get('/permohonan/{id}',             [PermohonanSuratController::class, 'show'])->name('permohonan.show');
        Route::get('/permohonan/{id}/download',    [PermohonanSuratController::class, 'download'])->name('permohonan.download');
    });

    // --- STAFF ---
    Route::prefix('staff')->name('staff.')->group(function () {
        // Permohonan
        Route::get('/permohonan',                  [PermohonanSuratController::class, 'staffIndex'])->name('permohonan.index');
        Route::get('/permohonan/{id}',             [PermohonanSuratController::class, 'staffShow'])->name('permohonan.show');
        Route::post('/permohonan/{id}/verifikasi', [PermohonanSuratController::class, 'verifikasi'])->name('permohonan.verifikasi');

        // Akun Warga
        Route::get('/akun',                        [AkunController::class, 'index'])->name('akun.index');
        Route::get('/akun/{id}',                   [AkunController::class, 'show'])->name('akun.show');
        Route::post('/akun/{id}/aktivasi',         [AkunController::class, 'aktivasi'])->name('akun.aktivasi');
        Route::post('/akun/{id}/tolak',            [AkunController::class, 'tolak'])->name('akun.tolak');
        Route::post('/akun/{id}/reaktivasi',       [AkunController::class, 'reaktivasi'])->name('akun.reaktivasi');

        // Master Jenis Surat
        Route::get('/jenis-surat',                 [MasterSuratController::class, 'index'])->name('jenis_surat.index');
        Route::get('/jenis-surat/tambah',          [MasterSuratController::class, 'create'])->name('jenis_surat.create');
        Route::post('/jenis-surat',                [MasterSuratController::class, 'store'])->name('jenis_surat.store');
        Route::get('/jenis-surat/{id}/edit',       [MasterSuratController::class, 'edit'])->name('jenis_surat.edit');
        Route::put('/jenis-surat/{id}',            [MasterSuratController::class, 'update'])->name('jenis_surat.update');
        Route::post('/jenis-surat/{id}/toggle',    [MasterSuratController::class, 'toggleStatus'])->name('jenis_surat.toggle');
        Route::delete('/jenis-surat/{id}',         [MasterSuratController::class, 'destroy'])->name('jenis_surat.destroy');

        // Data Penduduk
        Route::get('/penduduk',                    [PermohonanSuratController::class, 'masterPenduduk'])->name('penduduk.index');
    });

    // --- KEPALA DESA ---
    Route::prefix('kades')->name('kades.')->group(function () {
        Route::get('/permohonan',                  [PermohonanSuratController::class, 'kadesIndex'])->name('permohonan.index');
        Route::get('/permohonan/{id}',             [PermohonanSuratController::class, 'kadesShow'])->name('permohonan.show');
        Route::post('/permohonan/{id}/persetujuan',[PermohonanSuratController::class, 'persetujuan'])->name('permohonan.persetujuan');
    });

});
