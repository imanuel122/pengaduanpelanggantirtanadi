<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\KategoriController as DashboardKategoriController;
use App\Http\Controllers\Dashboard\LaporanController as DashboardLaporanController;
use App\Http\Controllers\Dashboard\PengaduanController as DashboardPengaduanController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
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
Route::get('/pengaduan/{kode}/surat/{jenis}', [PengaduanController::class, 'suratStatus']);
Route::get('/lacak', [PengaduanController::class, 'lacak']);

Route::post('/pengaduan/{kode}/setuju', [PengaduanController::class, 'setujuiBiaya']);
Route::post('/pengaduan/{kode}/tolak-biaya', [PengaduanController::class, 'tolakBiaya']);

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

    Route::get('/dashboard/kategori', [DashboardKategoriController::class, 'index']);
    Route::post('/dashboard/kategori', [DashboardKategoriController::class, 'store']);
    Route::put('/dashboard/kategori/{kategori}', [DashboardKategoriController::class, 'update']);
    Route::delete('/dashboard/kategori/{kategori}', [DashboardKategoriController::class, 'destroy']);

    Route::get('/dashboard/user', [DashboardUserController::class, 'index']);
    Route::post('/dashboard/user', [DashboardUserController::class, 'store']);
    Route::put('/dashboard/user/{user}', [DashboardUserController::class, 'update']);
    Route::delete('/dashboard/user/{user}', [DashboardUserController::class, 'destroy']);

    Route::get('/dashboard/laporan', [DashboardLaporanController::class, 'index']);
    Route::get('/dashboard/laporan/export-pdf', [DashboardLaporanController::class, 'exportPdf']);
    Route::get('/dashboard/laporan/export-csv', [DashboardLaporanController::class, 'exportCsv']);
    Route::get('/dashboard/laporan/keuangan', [DashboardLaporanController::class, 'keuangan']);
    Route::get('/dashboard/laporan/keuangan/export-pdf', [DashboardLaporanController::class, 'keuanganExportPdf']);
    Route::get('/dashboard/laporan/keuangan/export-csv', [DashboardLaporanController::class, 'keuanganExportCsv']);
    Route::get('/dashboard/laporan/tunggakan', [DashboardLaporanController::class, 'tunggakan']);
    Route::get('/dashboard/laporan/tunggakan/export-pdf', [DashboardLaporanController::class, 'tunggakanExportPdf']);
    Route::get('/dashboard/laporan/tunggakan/export-csv', [DashboardLaporanController::class, 'tunggakanExportCsv']);

    Route::get('/dashboard/pengaduan', [DashboardPengaduanController::class, 'index']);
    Route::get('/dashboard/pengaduan/{pengaduan}', [DashboardPengaduanController::class, 'show']);
    Route::post('/dashboard/pengaduan/{pengaduan}/mulai-pengecekan', [DashboardPengaduanController::class, 'mulaiPengecekan']);
    Route::post('/dashboard/pengaduan/{pengaduan}/verifikasi', [DashboardPengaduanController::class, 'verifikasi']);
    Route::post('/dashboard/pengaduan/{pengaduan}/verifikasi-pembayaran', [DashboardPengaduanController::class, 'verifikasiPembayaran']);
    Route::post('/dashboard/pengaduan/{pengaduan}/tolak-pembayaran', [DashboardPengaduanController::class, 'tolakPembayaran']);
    Route::post('/dashboard/pengaduan/{pengaduan}/tolak', [DashboardPengaduanController::class, 'tolak']);
    Route::post('/dashboard/pengaduan/{pengaduan}/mulai-proses', [DashboardPengaduanController::class, 'mulaiProses']);
    Route::post('/dashboard/pengaduan/{pengaduan}/log-proses', [DashboardPengaduanController::class, 'logProses']);
    Route::post('/dashboard/pengaduan/{pengaduan}/selesai', [DashboardPengaduanController::class, 'selesai']);
});