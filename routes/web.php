<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/pengaduan/buat', [PengaduanController::class, 'create']);
Route::post('/pengaduan', [PengaduanController::class, 'store']);

Route::get('/lacak', function () {
    return 'Halaman Lacak Pengaduan — segera dibuat';
});

Route::post('/kontak', function () {
    return back()->with('success', 'Pesan terkirim! (placeholder, logic belum dibuat)');
});