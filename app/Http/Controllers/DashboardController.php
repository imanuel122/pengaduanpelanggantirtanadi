<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diverifikasi' => Pengaduan::where('status', 'diverifikasi')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        $terbaru = Pengaduan::with('kategori')->latest()->take(8)->get();

        return view('dashboard.index', compact('stats', 'terbaru'));
    }
}