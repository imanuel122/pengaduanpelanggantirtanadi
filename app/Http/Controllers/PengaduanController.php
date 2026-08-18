<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

            // Sekarang bisa banyak foto sekaligus
            'foto'   => ['nullable', 'array', 'max:6'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'], // masing-masing maks 5MB
        ], [
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
            'foto.max' => 'Maksimal 6 foto yang bisa diunggah.',
            'foto.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.*.max' => 'Ukuran tiap foto maksimal 5MB.',
        ]);

        // Pisahkan data foto dari data yang mau disimpan ke tabel pengaduans
        $fotoFiles = $validated['foto'] ?? [];
        unset($validated['foto']);

        $pengaduan = Pengaduan::create($validated);

        // Simpan tiap foto ke tabel pengaduan_fotos
        // Pastikan sudah jalankan: php artisan storage:link
        foreach ($fotoFiles as $file) {
            $path = $file->store('pengaduan', 'public');
            $pengaduan->fotos()->create(['path' => $path]);
        }

        // TanggapanPengaduan "Pengaduan berhasil dikirim" otomatis dibuat
        // lewat event `created` di Model Pengaduan.

        return redirect('/pengaduan/buat')->with('success', $pengaduan->kode_pengaduan);
    }

    // Tampilkan (preview) surat pengaduan dalam bentuk PDF
    public function surat(string $kode)
    {
        $pengaduan = Pengaduan::with(['kategori', 'fotos'])
            ->where('kode_pengaduan', $kode)
            ->firstOrFail();

        // Format tanggal ke Bahasa Indonesia (tanpa perlu extension locale khusus)
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $tanggal = $pengaduan->created_at;
        $tanggalIndo = $tanggal->day . ' ' . $bulanIndo[$tanggal->month] . ' ' . $tanggal->year;

        // QR 1: melacak status pengaduan
        $qrLacakBase64 = base64_encode(
            QrCode::format('svg')->size(180)->margin(1)
                ->generate(url('/lacak?kode=' . $pengaduan->kode_pengaduan))
        );

        // QR 2: melihat/cetak ulang surat ini
        $qrSuratBase64 = base64_encode(
            QrCode::format('svg')->size(180)->margin(1)
                ->generate(url('/pengaduan/' . $pengaduan->kode_pengaduan . '/surat'))
        );

        $pdf = Pdf::loadView('pengaduan.surat-pdf', [
            'pengaduan' => $pengaduan,
            'tanggalIndo' => $tanggalIndo,
            'qrLacakBase64' => $qrLacakBase64,
            'qrSuratBase64' => $qrSuratBase64,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Surat-Pengaduan-' . $pengaduan->kode_pengaduan . '.pdf');
    }
}
