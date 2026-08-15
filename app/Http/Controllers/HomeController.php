<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'kategoris' => KategoriPengaduan::orderBy('nama')->take(6)->get(),
            // 'totalPengaduan' => \App\Models\Pengaduan::count(),
            // 'tingkatSelesai' => ... hitung persentase status 'selesai',
            // 'rataVerifikasi' => ... hitung rata-rata waktu diverifikasi,
        ]);
    }
}