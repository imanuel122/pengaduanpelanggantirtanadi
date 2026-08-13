<?php

namespace Database\Seeders;

use App\Models\KategoriPengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun pegawai default (pelanggan tidak perlu akun)
        User::create([
            'name' => 'Admin PDAM Padang Bulan',
            'email' => 'admin@pdamtirtanadi.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Lapangan 1',
            'email' => 'petugas@pdamtirtanadi.test',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // Kategori pengaduan — lengkap mengacu ke seluruh Jenis Aduan Halo Tirtanadi
        $kategoris = [
            // Kelompok: Air
            ['nama' => 'Air Mati', 'deskripsi' => 'Air tidak mengalir sama sekali ke rumah pelanggan'],
            ['nama' => 'Air Kecil', 'deskripsi' => 'Aliran air kecil / tidak lancar'],
            ['nama' => 'Air Keruh', 'deskripsi' => 'Kualitas air keruh atau berwarna'],
            ['nama' => 'Air Berbau', 'deskripsi' => 'Air berbau tidak sedap'],
            ['nama' => 'Air Tidak Normal', 'deskripsi' => 'Kondisi air tidak normal lainnya'],

            // Kelompok: Pipa & Kebocoran
            ['nama' => 'Bocor Pipa Dinas', 'deskripsi' => 'Kebocoran pipa dinas menuju rumah pelanggan'],
            ['nama' => 'Bocor Pipa Distribusi', 'deskripsi' => 'Kebocoran pipa distribusi utama'],
            ['nama' => 'Bocor Pipa Transmisi', 'deskripsi' => 'Kebocoran pipa transmisi'],
            ['nama' => 'Bocor Sekitar Meter/Kopling Bocor', 'deskripsi' => 'Kebocoran di sekitar meteran atau sambungan kopling'],
            ['nama' => 'Rehab Pipa Dinas', 'deskripsi' => 'Perbaikan/rehabilitasi pipa dinas'],

            // Kelompok: Meteran
            ['nama' => 'Meter Mati', 'deskripsi' => 'Meteran air tidak berfungsi/mati'],
            ['nama' => 'Meter Pecah', 'deskripsi' => 'Meteran air pecah'],
            ['nama' => 'Meter Kabur', 'deskripsi' => 'Angka pada meteran tidak terbaca jelas'],
            ['nama' => 'Meter Kadaluarsa', 'deskripsi' => 'Meteran sudah melewati masa pakai/tera'],
            ['nama' => 'Meter Hilang', 'deskripsi' => 'Meteran air hilang'],
            ['nama' => 'Meter Labil', 'deskripsi' => 'Putaran meteran tidak stabil'],
            ['nama' => 'Meter Ragu', 'deskripsi' => 'Pelanggan ragu keakuratan meteran'],
            ['nama' => 'Pindah Letak Meter', 'deskripsi' => 'Permintaan pemindahan letak meteran'],
            ['nama' => 'Tinggikan Letak Meter', 'deskripsi' => 'Permintaan peninggian letak meteran'],
            ['nama' => 'Pasang Box Meter', 'deskripsi' => 'Pemasangan box pelindung meteran'],
            ['nama' => 'Pengaman Meter Tidak Ada', 'deskripsi' => 'Pengaman/pelindung meteran tidak ada'],
            ['nama' => 'Segel Meter/Kopling Putus', 'deskripsi' => 'Segel meteran atau kopling putus'],
            ['nama' => 'Pasang Kembali', 'deskripsi' => 'Permintaan pemasangan kembali meteran'],

            // Kelompok: Stop Kran & Gate Valve
            ['nama' => 'Stop Kran Tidak Berfungsi', 'deskripsi' => 'Stop kran rusak atau tidak berfungsi'],
            ['nama' => 'Bongkar Pasang Gate Valve', 'deskripsi' => 'Bongkar pasang gate valve'],

            // Kelompok: Lubang Bor / Stratpot
            ['nama' => 'Perbaikan Lubang Bor', 'deskripsi' => 'Perbaikan lubang bor'],
            ['nama' => 'Tutup Lobang Bor', 'deskripsi' => 'Penutupan lubang bor'],
            ['nama' => 'Bocor Lobang Bor', 'deskripsi' => 'Kebocoran pada lubang bor'],
            ['nama' => 'Pindah Lobang Bor', 'deskripsi' => 'Permintaan pemindahan lubang bor'],
            ['nama' => 'Tryhole', 'deskripsi' => 'Pengecekan tryhole'],
            ['nama' => 'Mencari Stratpot', 'deskripsi' => 'Pencarian stratpot'],
            ['nama' => 'Meninggikan Stratpot', 'deskripsi' => 'Peninggian stratpot'],
            ['nama' => 'Pemasangan Stratpot', 'deskripsi' => 'Pemasangan stratpot baru'],

            // Kelompok: Saluran Limbah
            ['nama' => 'Saluran Air Limbah (SAL) Tersumbat Limbah Padat', 'deskripsi' => 'SAL tersumbat limbah padat'],
            ['nama' => 'Bak Kontrol Tersumbat Limbah Padat', 'deskripsi' => 'Bak kontrol tersumbat limbah padat'],
            ['nama' => 'IC Tersumbat Limbah Padat', 'deskripsi' => 'IC (inspection chamber) tersumbat limbah padat'],
            ['nama' => 'Pipa Limbah Rumah/Bak Kontrol/IC: Bocor/Pecah', 'deskripsi' => 'Pipa limbah rumah, bak kontrol, atau IC bocor/pecah'],
            ['nama' => 'Cover Bak Kontrol/IC: Rusak-Bocor-Tidak Ada', 'deskripsi' => 'Cover bak kontrol/IC rusak, bocor, atau tidak ada'],

            // Kelompok: Administrasi & Layanan Pelanggan
            ['nama' => 'Komplain Tagihan', 'deskripsi' => 'Kesalahan atau ketidaksesuaian tagihan'],
            ['nama' => 'Pencatat Meter Tidak Datang', 'deskripsi' => 'Petugas pencatat meter tidak datang sesuai jadwal'],
            ['nama' => 'Konfirmasi No. Pelanggan', 'deskripsi' => 'Konfirmasi nomor pelanggan (NPA)'],
            ['nama' => 'Pasang Baru', 'deskripsi' => 'Permohonan pemasangan sambungan baru'],
            ['nama' => 'Kasus Pencurian Air', 'deskripsi' => 'Laporan dugaan pencurian air'],
            ['nama' => 'Bertanya Informasi', 'deskripsi' => 'Pertanyaan umum seputar layanan PDAM'],
            ['nama' => 'Lain-Lain', 'deskripsi' => 'Keluhan di luar kategori di atas'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriPengaduan::create($kategori);
        }
    }
}
