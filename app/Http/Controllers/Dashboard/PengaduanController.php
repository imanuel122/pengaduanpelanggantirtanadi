<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // Daftar pengaduan masuk, dengan filter status & pencarian
    public function index(Request $request)
    {
        $query = Pengaduan::with(['kategori', 'petugas'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode_pengaduan', 'like', "%{$cari}%")
                    ->orWhere('nama_pelapor', 'like', "%{$cari}%")
                    ->orWhere('judul', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->query('dari'));
        }

        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->query('sampai'));
        }

        $pengaduans = $query->paginate(15)->withQueryString();

        $jumlahPerStatus = [
            'semua' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'pengecekan' => Pengaduan::where('status', 'pengecekan')->count(),
            'menunggu_persetujuan' => Pengaduan::where('status', 'menunggu_persetujuan')->count(),
            'menunggu_verifikasi_pembayaran' => Pengaduan::where('status', 'menunggu_verifikasi_pembayaran')->count(),
            'diverifikasi' => Pengaduan::where('status', 'diverifikasi')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        return view('dashboard.pengaduan.index', [
            'pengaduans' => $pengaduans,
            'statusFilter' => $request->status,
            'cari' => $request->cari,
            'dari' => $request->query('dari', ''),
            'sampai' => $request->query('sampai', ''),
            'jumlahPerStatus' => $jumlahPerStatus,
        ]);
    }

    // Detail 1 pengaduan
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['kategori', 'petugas', 'fotos', 'tanggapans.user', 'tanggapans.fotos']);
        $petugasList = User::where('role', 'petugas')->orderBy('name')->get();

        return view('dashboard.pengaduan.show', compact('pengaduan', 'petugasList'));
    }

    /*
    |--------------------------------------------------------------------------
    | ALUR STATUS — tiap method di bawah cuma boleh dipanggil dari status
    | tertentu (guard di awal method). Ini memaksa alurnya tetap linear,
    | gak bisa "loncat" status sembarangan lewat dropdown bebas lagi.
    |--------------------------------------------------------------------------
    */

    // BARU -> PENGECEKAN (pilih petugas yang akan cek lokasi)
    public function mulaiPengecekan(Request $request, Pengaduan $pengaduan)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menugaskan petugas.');
        abort_unless($pengaduan->status === 'baru', 422, 'Pengaduan ini sudah bukan status Baru.');

        $validated = $request->validate([
            'petugas_id' => ['required', 'exists:users,id'],
            'jadwal_pengecekan' => ['required', 'date'],
        ], [
            'petugas_id.required' => 'Pilih petugas yang akan melakukan pengecekan.',
            'jadwal_pengecekan.required' => 'Jadwal rencana pengecekan wajib diisi.',
            'jadwal_pengecekan.date' => 'Format jadwal pengecekan tidak valid.',
        ]);

        $petugas = User::find($validated['petugas_id']);

        $pengaduan->update([
            'status' => 'pengecekan',
            'petugas_id' => $validated['petugas_id'],
            'jadwal_pengecekan' => $validated['jadwal_pengecekan'],
            'tanggal_mulai_pengecekan' => now(),
            'petugas_pengecekan_nama' => $petugas->name,
        ]);

        $jadwalIndo = Pengaduan::formatTanggalIndo($pengaduan->jadwal_pengecekan, true);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: {$petugas->name}. Jadwal rencana pengecekan: {$jadwalIndo}. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.",
            'status_baru' => 'pengecekan',
            'jenis_surat' => 'pengecekan',
        ]);

        return back()->with('success', 'Pengaduan diteruskan ke tahap pengecekan.');
    }

    // PENGECEKAN -> DIVERIFIKASI (isi hasil cek + SPKP + foto lapangan)
    public function verifikasi(Request $request, Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'pengecekan', 422, 'Pengaduan ini bukan status Pengecekan.');

        $validated = $request->validate([
            'perlu_spkp' => ['required', 'in:ya,tidak'],
            'hasil_pemeriksaan' => ['required', 'string', 'min:5'],
            'total_biaya' => ['nullable', 'numeric', 'min:0'],
            'rincian_biaya_file' => [
                'nullable', 'file', 'mimes:doc,docx,xls,xlsx,pdf', 'max:5120',
                function ($attribute, $value, $fail) use ($request) {
                    $adaBiayaDiisi = $request->filled('total_biaya') && (float) $request->input('total_biaya') > 0;
                    if ($adaBiayaDiisi && ! $value) {
                        $fail('Upload dokumen rincian biaya wajib diisi kalau ada total biaya.');
                    }
                },
            ],
            'foto_pengecekan' => ['nullable', 'array', 'max:6'],
            'foto_pengecekan.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'perlu_spkp.required' => 'Pilih apakah perlu SPKP atau tidak.',
            'hasil_pemeriksaan.required' => 'Hasil pemeriksaan wajib diisi.',
            'hasil_pemeriksaan.min' => 'Hasil pemeriksaan minimal 5 karakter.',
            'total_biaya.numeric' => 'Total biaya harus berupa angka.',
            'total_biaya.min' => 'Total biaya tidak boleh negatif.',
            'rincian_biaya_file.file' => 'Dokumen rincian biaya tidak valid.',
            'rincian_biaya_file.mimes' => 'Dokumen rincian biaya harus berformat Word (doc/docx), Excel (xls/xlsx), atau PDF.',
            'rincian_biaya_file.max' => 'Ukuran dokumen rincian biaya maksimal 5MB.',
            'foto_pengecekan.max' => 'Maksimal 6 foto yang bisa diunggah.',
            'foto_pengecekan.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_pengecekan.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_pengecekan.*.max' => 'Ukuran tiap foto maksimal 5MB.',
        ]);

        // Ada biaya yang perlu disetujui pelanggan hanya kalau perlu SPKP DAN
        // admin mengisi nominal total_biaya lebih dari 0. Kalau tidak ada biaya
        // (gratis / tidak perlu SPKP), alur lanjut otomatis seperti biasa tanpa
        // menunggu persetujuan pelanggan.
        $adaBiaya = $validated['perlu_spkp'] === 'ya' && (float) ($validated['total_biaya'] ?? 0) > 0;
        $statusBaru = $adaBiaya ? 'menunggu_persetujuan' : 'diverifikasi';

        $rincianBiayaFilePath = null;
        $rincianBiayaFileNamaAsli = null;
        if ($request->hasFile('rincian_biaya_file')) {
            $dokumen = $request->file('rincian_biaya_file');
            $rincianBiayaFileNamaAsli = $dokumen->getClientOriginalName();
            $namaFileBaru = Pengaduan::namaFileUpload('Rincian-Biaya', $pengaduan->nama_pelapor, $pengaduan->kode_pengaduan, $dokumen->getClientOriginalExtension());
            $rincianBiayaFilePath = $dokumen->storeAs('rincian-biaya', $namaFileBaru, 'public');
        }

        $pengaduan->update([
            'status' => $statusBaru,
            'perlu_spkp' => $validated['perlu_spkp'],
            'hasil_pemeriksaan' => $validated['hasil_pemeriksaan'],
            'tanggal_pemeriksaan' => now(),
            // Kalau gak ada biaya, pengaduan langsung resmi "diverifikasi" di titik ini juga --
            // jadi Surat Verifikasi Pengaduan langsung tersedia bersamaan dengan Surat Hasil Pengecekan.
            'tanggal_diverifikasi' => $statusBaru === 'diverifikasi' ? now() : null,
            'total_biaya' => $validated['perlu_spkp'] === 'ya' ? ($validated['total_biaya'] ?? null) : null,
            'rincian_biaya_file' => $validated['perlu_spkp'] === 'ya' ? $rincianBiayaFilePath : null,
            'rincian_biaya_file_nama_asli' => $validated['perlu_spkp'] === 'ya' ? $rincianBiayaFileNamaAsli : null,
            'status_persetujuan' => $adaBiaya ? 'menunggu' : null,
        ]);

        $labelSpkp = $validated['perlu_spkp'] === 'ya' ? 'Perlu SPKP' : 'Tidak Perlu SPKP';
        $pesan = "Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: {$validated['hasil_pemeriksaan']} ({$labelSpkp}). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.";

        if ($adaBiaya) {
            $pesan .= ' Ditemukan biaya sebesar ' . $pengaduan->formattedTotalBiaya() . ', menunggu persetujuan pelanggan sebelum dilanjutkan.';
        } else {
            $pesan .= ' Tidak ada biaya yang dikenakan, pengaduan telah diverifikasi dan dilanjutkan.';
        }

        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => $pesan,
            'status_baru' => $statusBaru,
            'jenis_surat' => 'hasil_pengecekan',
        ]);

        foreach ($validated['foto_pengecekan'] ?? [] as $file) {
            $path = $file->store('dokumentasi', 'public');
            $tanggapan->fotos()->create(['path' => $path]);
        }

        // Simpan referensi tanggapan ini di pengaduan, dipakai buat ambil lampiran
        // foto pengecekan di Surat Hasil Pengecekan.
        $pengaduan->update(['tanggapan_pengecekan_id' => $tanggapan->id]);

        return back()->with('success', $adaBiaya
            ? 'Pengaduan diperiksa. Menunggu persetujuan biaya dari pelanggan.'
            : 'Pengaduan berhasil diverifikasi.');
    }

    // MENUNGGU_VERIFIKASI_PEMBAYARAN -> DIVERIFIKASI (admin cek bukti bayar valid, lanjutkan)
    public function verifikasiPembayaran(Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'menunggu_verifikasi_pembayaran', 422, 'Pengaduan ini tidak sedang menunggu verifikasi pembayaran.');

        $pengaduan->update([
            'status' => 'diverifikasi',
            'tanggal_diverifikasi' => now(),
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya. Surat Verifikasi Pengaduan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.',
            'status_baru' => 'diverifikasi',
            'jenis_surat' => 'verifikasi_pengaduan',
        ]);

        return back()->with('success', 'Pembayaran terverifikasi, pengaduan dilanjutkan.');
    }

    // MENUNGGU_VERIFIKASI_PEMBAYARAN -> MENUNGGU_PERSETUJUAN (bukti bayar ditolak, pelanggan upload ulang)
    public function tolakPembayaran(Request $request, Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'menunggu_verifikasi_pembayaran', 422, 'Pengaduan ini tidak sedang menunggu verifikasi pembayaran.');

        $validated = $request->validate([
            'catatan_verifikasi_pembayaran' => ['required', 'string', 'min:5'],
        ], [
            'catatan_verifikasi_pembayaran.required' => 'Jelaskan alasan bukti pembayaran ditolak.',
            'catatan_verifikasi_pembayaran.min' => 'Alasan minimal 5 karakter.',
        ]);

        $pengaduan->update([
            'status' => 'menunggu_persetujuan',
            'status_persetujuan' => 'menunggu',
            'catatan_verifikasi_pembayaran' => $validated['catatan_verifikasi_pembayaran'],
            'bukti_pembayaran' => null,
            'bukti_pembayaran_nama_asli' => null,
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => 'Bukti pembayaran ditolak: ' . $validated['catatan_verifikasi_pembayaran'] . '. Pelanggan diminta mengunggah ulang bukti pembayaran.',
            'status_baru' => 'menunggu_persetujuan',
        ]);

        return back()->with('success', 'Bukti pembayaran ditolak, pelanggan diminta mengunggah ulang.');
    }

    // PENGECEKAN -> DITOLAK (isi alasan penolakan)
    public function tolak(Request $request, Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'pengecekan', 422, 'Pengaduan ini bukan status Pengecekan.');

        $validated = $request->validate([
            'catatan_penolakan' => ['required', 'string', 'min:5'],
        ], [
            'catatan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'catatan_penolakan.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $pengaduan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_penolakan'],
            'tanggal_ditolak' => now(),
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan ditolak. Alasan: {$validated['catatan_penolakan']} Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.",
            'status_baru' => 'ditolak',
            'jenis_surat' => 'ditolak',
        ]);

        return back()->with('success', 'Pengaduan telah ditolak.');
    }

    // DIVERIFIKASI -> DIPROSES (pilih petugas pelaksana)
    public function mulaiProses(Request $request, Pengaduan $pengaduan)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menugaskan pelaksana.');
        abort_unless($pengaduan->status === 'diverifikasi', 422, 'Pengaduan ini bukan status Diverifikasi.');

        $validated = $request->validate([
            'pelaksana_id' => ['required', 'exists:users,id'],
        ], [
            'pelaksana_id.required' => 'Pilih petugas yang akan menindaklanjuti pengaduan ini.',
        ]);

        $pelaksana = User::find($validated['pelaksana_id']);

        $pengaduan->update([
            'status' => 'diproses',
            'petugas_id' => $validated['pelaksana_id'],
            'tanggal_mulai_proses' => now(),
            'pelaksana_proses_nama' => $pelaksana->name,
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan mulai dikerjakan oleh: {$pelaksana->name}. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.",
            'status_baru' => 'diproses',
            'jenis_surat' => 'proses',
        ]);

        return back()->with('success', 'Pengaduan mulai diproses.');
    }

    // DIPROSES: catat progres penanganan (bisa berkali-kali, status TIDAK berubah)
    public function logProses(Request $request, Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'diproses', 422, 'Pengaduan ini bukan status Diproses.');

        $validated = $request->validate([
            'pesan' => ['required', 'string', 'min:5'],
            'foto' => ['nullable', 'array', 'max:6'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'pesan.required' => 'Catatan progres wajib diisi.',
            'pesan.min' => 'Catatan progres minimal 5 karakter.',
            'foto.max' => 'Maksimal 6 foto yang bisa diunggah.',
            'foto.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.*.max' => 'Ukuran tiap foto maksimal 5MB.',
        ]);

        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => $validated['pesan'],
            'status_baru' => null, // catatan progres, bukan perubahan status
        ]);

        foreach ($validated['foto'] ?? [] as $file) {
            $path = $file->store('dokumentasi', 'public');
            $tanggapan->fotos()->create(['path' => $path]);
        }

        return back()->with('success', 'Progres penanganan berhasil dicatat.');
    }

    // DIPROSES -> SELESAI (isi catatan penyelesaian buat pelanggan)
    public function selesai(Request $request, Pengaduan $pengaduan)
    {
        abort_unless($pengaduan->status === 'diproses', 422, 'Pengaduan ini bukan status Diproses.');

        $validated = $request->validate([
            'catatan_selesai' => ['required', 'string', 'min:5'],
        ], [
            'catatan_selesai.required' => 'Catatan penyelesaian wajib diisi.',
            'catatan_selesai.min' => 'Catatan penyelesaian minimal 5 karakter.',
        ]);

        $pengaduan->update([
            'status' => 'selesai',
            'tanggal_selesai' => now(),
            'catatan_selesai' => $validated['catatan_selesai'],
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => $validated['catatan_selesai'] . ' Surat keterangan selesai sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.',
            'status_baru' => 'selesai',
            'jenis_surat' => 'selesai',
        ]);

        return back()->with('success', 'Pengaduan telah diselesaikan.');
    }
}