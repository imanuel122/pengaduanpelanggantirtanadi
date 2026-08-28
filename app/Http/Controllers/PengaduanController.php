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

    // Tampilkan halaman lacak pengaduan (dengan atau tanpa kode pencarian)
    public function lacak(Request $request)
    {
        $kode = trim((string) $request->query('kode', ''));
        $pengaduan = null;
        $sudahDicari = $kode !== '';

        if ($sudahDicari) {
            $pengaduan = Pengaduan::with(['kategori', 'petugas', 'fotos', 'tanggapans.fotos'])
                ->where('kode_pengaduan', $kode)
                ->first();
        }

        return view('pengaduan.lacak', [
            'pengaduan' => $pengaduan,
            'kodeDicari' => $kode,
            'sudahDicari' => $sudahDicari,
        ]);
    }

    // Pelanggan menyetujui biaya + wajib upload bukti pembayaran -> menunggu admin verifikasi
    public function setujuiBiaya(Request $request, string $kode)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kode)->firstOrFail();
        abort_unless($pengaduan->status === 'menunggu_persetujuan', 422, 'Pengaduan ini tidak sedang menunggu persetujuan.');

        $validated = $request->validate([
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'bukti_pembayaran.required' => 'Upload bukti pembayaran terlebih dahulu untuk menyetujui.',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa gambar (JPG/PNG) atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 5MB.',
        ]);

        $file = $request->file('bukti_pembayaran');
        $namaAsli = $file->getClientOriginalName();
        $namaFileBaru = Pengaduan::namaFileUpload('Bukti-Pembayaran', $pengaduan->nama_pelapor, $pengaduan->kode_pengaduan, $file->getClientOriginalExtension());
        $path = $file->storeAs('bukti-pembayaran', $namaFileBaru, 'public');

        $pengaduan->update([
            'status' => 'menunggu_verifikasi_pembayaran',
            'status_persetujuan' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'bukti_pembayaran' => $path,
            'bukti_pembayaran_nama_asli' => $namaAsli,
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => null,
            'pesan' => 'Pelanggan menyetujui biaya sebesar ' . $pengaduan->formattedTotalBiaya() . ' dan mengunggah bukti pembayaran. Menunggu verifikasi admin.',
            'status_baru' => 'menunggu_verifikasi_pembayaran',
        ]);

        return back()->with('success', 'Terima kasih, bukti pembayaran Anda sedang diverifikasi oleh admin.');
    }

    // Pelanggan menolak biaya -> pengaduan dibatalkan
    public function tolakBiaya(Request $request, string $kode)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kode)->firstOrFail();
        abort_unless($pengaduan->status === 'menunggu_persetujuan', 422, 'Pengaduan ini tidak sedang menunggu persetujuan.');

        $validated = $request->validate([
            'catatan_persetujuan' => ['nullable', 'string', 'max:500'],
        ], [
            'catatan_persetujuan.max' => 'Alasan maksimal 500 karakter.',
        ]);

        $pengaduan->update([
            'status' => 'ditolak',
            'status_persetujuan' => 'ditolak',
            'tanggal_persetujuan' => now(),
            'tanggal_ditolak' => now(),
            'catatan_persetujuan' => $validated['catatan_persetujuan'] ?? null,
            'catatan_admin' => 'Dibatalkan oleh pelanggan (tidak menyetujui biaya yang diajukan).',
        ]);

        $pesan = 'Pelanggan tidak menyetujui biaya yang diajukan, pengaduan dibatalkan.';
        if (!empty($validated['catatan_persetujuan'])) {
            $pesan .= ' Alasan: ' . $validated['catatan_persetujuan'];
        }
        $pesan .= ' Surat pemberitahuan sudah bisa dilihat/diunduh di halaman Lacak Pengaduan.';

        $pengaduan->tanggapans()->create([
            'user_id' => null,
            'pesan' => $pesan,
            'status_baru' => 'ditolak',
            'jenis_surat' => 'ditolak',
        ]);

        return back()->with('success', 'Pengaduan telah dibatalkan sesuai permintaan Anda.');
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

        // Base URL dari domain yang BENERAN sedang dipakai request ini (bukan config APP_URL,
        // yang gampang telat disesuaikan pas ganti domain lokal .test) -- supaya QR code selalu
        // mengarah ke domain yang benar-benar bisa diakses saat discan dari HP.
        $baseUrl = request()->root();

        // QR 1: melacak status pengaduan
        $qrLacakBase64 = base64_encode(
            QrCode::format('svg')->size(260)->margin(15)->errorCorrection('L')
                ->generate($baseUrl . '/lacak?kode=' . $pengaduan->kode_pengaduan)
        );

        // QR 2: melihat/cetak ulang surat ini
        $qrSuratBase64 = base64_encode(
            QrCode::format('svg')->size(260)->margin(15)->errorCorrection('L')
                ->generate($baseUrl . '/pengaduan/' . $pengaduan->kode_pengaduan . '/surat')
        );

        $pdf = Pdf::loadView('pengaduan.surat-pdf', [
            'pengaduan' => $pengaduan,
            'tanggalIndo' => $tanggalIndo,
            'qrLacakBase64' => $qrLacakBase64,
            'qrSuratBase64' => $qrSuratBase64,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Surat-Pengaduan-' . $pengaduan->kode_pengaduan . '.pdf');
    }

    // Tampilkan surat pemberitahuan sesuai tahapan status: pengecekan/verifikasi/proses/selesai
    public function suratStatus(string $kode, string $jenis)
    {
        abort_unless(in_array($jenis, ['pengecekan', 'hasil_pengecekan', 'verifikasi_pengaduan', 'proses', 'selesai', 'ditolak']), 404);

        $pengaduan = Pengaduan::with(['kategori', 'petugas', 'tanggapanPengecekan.fotos'])
            ->where('kode_pengaduan', $kode)
            ->firstOrFail();

        abort_unless($pengaduan->suratTersedia($jenis), 404, 'Surat ini belum tersedia untuk pengaduan tersebut.');

        // Tanggal surat = tanggal event terkait terjadi (bukan tanggal pengaduan awal,
        // dan bukan tanggal saat surat ini dibuka/didownload).
        $tanggalEvent = match ($jenis) {
            'pengecekan' => $pengaduan->tanggal_mulai_pengecekan,
            'hasil_pengecekan' => $pengaduan->tanggal_pemeriksaan,
            'verifikasi_pengaduan' => $pengaduan->tanggal_diverifikasi,
            'proses' => $pengaduan->tanggal_mulai_proses,
            'selesai' => $pengaduan->tanggal_selesai,
            'ditolak' => $pengaduan->tanggal_ditolak,
        };
        $tanggalIndo = Pengaduan::formatTanggalIndo($tanggalEvent);

        $baseUrl = request()->root();

        // QR: melihat/cetak ulang surat ini
        $qrSuratBase64 = base64_encode(
            QrCode::format('svg')->size(260)->margin(15)->errorCorrection('L')
                ->generate($baseUrl . '/pengaduan/' . $pengaduan->kode_pengaduan . '/surat/' . $jenis)
        );

        // QR: lacak status pengaduan
        $qrLacakBase64 = base64_encode(
            QrCode::format('svg')->size(260)->margin(15)->errorCorrection('L')
                ->generate($baseUrl . '/lacak?kode=' . $pengaduan->kode_pengaduan)
        );

        // Lampiran foto (halaman terpisah): Surat Hasil Pengecekan pakai foto pengecekan
        // dari petugas, Surat Verifikasi Pengaduan pakai foto bukti pembayaran pelanggan.
        // Disimpan sebagai raw path (relatif ke storage/app/public), bukan URL --
        // dompdf butuh path filesystem asli buat merender gambar lokal.
        $fotoLampiran = match ($jenis) {
            'hasil_pengecekan' => $pengaduan->tanggapanPengecekan?->fotos->pluck('path')->all() ?? [],
            'verifikasi_pengaduan' => $pengaduan->buktiPembayaranIsGambar() && $pengaduan->bukti_pembayaran
                ? [$pengaduan->bukti_pembayaran]
                : [],
            default => [],
        };

        $pdf = Pdf::loadView('pengaduan.surat-status-pdf', [
            'pengaduan' => $pengaduan,
            'jenis' => $jenis,
            'tanggalIndo' => $tanggalIndo,
            'qrLacakBase64' => $qrLacakBase64,
            'qrSuratBase64' => $qrSuratBase64,
            'fotoLampiran' => $fotoLampiran,
        ])->setPaper('a4', 'portrait');

        $namaFile = match ($jenis) {
            'pengecekan' => 'Surat-Pemberitahuan-Pengecekan-',
            'hasil_pengecekan' => 'Surat-Hasil-Pengecekan-',
            'verifikasi_pengaduan' => 'Surat-Verifikasi-Pengaduan-',
            'proses' => 'Surat-Pemberitahuan-Proses-',
            'selesai' => 'Surat-Keterangan-Selesai-',
            'ditolak' => 'Surat-Pemberitahuan-Penolakan-',
        };

        return $pdf->stream($namaFile . $pengaduan->kode_pengaduan . '.pdf');
    }
}
