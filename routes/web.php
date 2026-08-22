<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\PengaduanController as DashboardPengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

Route::get('/pengaduan/buat', [PengaduanController::class, 'create']);
Route::post('/pengaduan', [PengaduanController::class, 'store']);
Route::get('/pengaduan/{kode}/surat', [PengaduanController::class, 'surat']);
Route::get('/lacak', [PengaduanController::class, 'lacak']);

Route::post('/kontak', function () {
    return back()->with('success', 'Pesan terkirim! (placeholder, logic belum dibuat)');
});

/*
|--------------------------------------------------------------------------
| Login Pegawai (guest only — kalau sudah login, otomatis dialihkan)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Dashboard Pegawai (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard/pengaduan', [DashboardPengaduanController::class, 'index']);
    Route::get('/dashboard/pengaduan/{pengaduan}', [DashboardPengaduanController::class, 'show']);
    Route::post('/dashboard/pengaduan/{pengaduan}/mulai-pengecekan', [DashboardPengaduanController::class, 'mulaiPengecekan']);
    Route::post('/dashboard/pengaduan/{pengaduan}/verifikasi', [DashboardPengaduanController::class, 'verifikasi']);
    Route::post('/dashboard/pengaduan/{pengaduan}/tolak', [DashboardPengaduanController::class, 'tolak']);
    Route::post('/dashboard/pengaduan/{pengaduan}/mulai-proses', [DashboardPengaduanController::class, 'mulaiProses']);
    Route::post('/dashboard/pengaduan/{pengaduan}/log-proses', [DashboardPengaduanController::class, 'logProses']);
    Route::post('/dashboard/pengaduan/{pengaduan}/selesai', [DashboardPengaduanController::class, 'selesai']);
});