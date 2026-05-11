<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanSuratController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Warga routes
    Route::get('/warga/permohonan/create', [PermohonanSuratController::class, 'create'])->name('warga.permohonan.create');
    Route::post('/warga/permohonan', [PermohonanSuratController::class, 'store'])->name('warga.permohonan.store');

    // Staff routes
    Route::get('/staff/permohonan/{id}', [PermohonanSuratController::class, 'show'])->name('staff.permohonan.show');
    Route::post('/staff/permohonan/{id}/verifikasi', [PermohonanSuratController::class, 'verifikasi'])->name('staff.permohonan.verifikasi');

    // Kades routes
    Route::post('/kades/permohonan/{id}/persetujuan', [PermohonanSuratController::class, 'persetujuan'])->name('kades.permohonan.persetujuan');
});
