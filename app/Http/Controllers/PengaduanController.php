<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // Tampilkan form buat pengaduan
    public function create()
    {
        return view('pengaduan.buat', [
            'kategoris' => KategoriPengaduan::orderBy('nama')->get(),
        ]);
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s.,\'-]+$/'],
            'no_hp'        => ['required', 'string', 'regex:/^[0-9+]{9,15}$/'],
            'no_pelanggan' => ['nullable', 'string', 'max:50', 'regex:/^[0-9]*$/'],
            'email'        => ['nullable', 'email', 'max:255'],
            'alamat'       => ['required', 'string', 'min:10'],
            'no_rumah_patokan' => ['nullable', 'string', 'max:255'],

            'kategori_pengaduan_id' => ['required', 'exists:kategori_pengaduans,id'],
            'judul'      => ['required', 'string', 'min:5', 'max:255'],
            'deskripsi'  => ['required', 'string', 'min:20'],

            'lokasi_kejadian' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'], // 5MB, khusus jpg/jpeg/png
        ], [
            // Pesan custom biar konsisten dengan pesan di frontend
            'nama_pelapor.required' => 'Nama lengkap wajib diisi.',
            'nama_pelapor.min' => 'Nama minimal 3 karakter.',
            'nama_pelapor.regex' => 'Nama hanya boleh berisi huruf.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus angka, 9-15 digit.',
            'no_pelanggan.regex' => 'Nomor Pelanggan hanya boleh berisi angka.',
            'email.email' => 'Format email tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat terlalu singkat, minimal 10 karakter.',
            'kategori_pengaduan_id.required' => 'Kategori pengaduan wajib dipilih.',
            'kategori_pengaduan_id.exists' => 'Kategori pengaduan tidak valid.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'judul.min' => 'Judul minimal 5 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Ceritakan lebih detail lagi, minimal 20 karakter.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Pastikan sudah jalankan: php artisan storage:link
            $validated['foto'] = $request->file('foto')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create($validated);

        // TanggapanPengaduan "Pengaduan berhasil dikirim" otomatis dibuat
        // lewat event `created` di Model Pengaduan.

        return redirect('/pengaduan/buat')->with('success', $pengaduan->kode_pengaduan);
    }
}
