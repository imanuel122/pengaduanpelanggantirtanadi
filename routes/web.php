<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pengaduan/buat', function () {
    return 'Halaman Buat Pengaduan — segera dibuat';
})->name('pengaduan.buat');

Route::get('/lacak', function () {
    return 'Halaman Lacak Pengaduan — segera dibuat';
})->name('pengaduan.lacak');

Route::post('/kontak', function () {
    return back()->with('success', 'Pesan terkirim! (placeholder, logic belum dibuat)');
})->name('kontak.kirim');