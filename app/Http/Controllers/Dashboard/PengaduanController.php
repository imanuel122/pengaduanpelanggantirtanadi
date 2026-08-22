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

        $pengaduans = $query->paginate(15)->withQueryString();

        $jumlahPerStatus = [
            'semua' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'pengecekan' => Pengaduan::where('status', 'pengecekan')->count(),
            'diverifikasi' => Pengaduan::where('status', 'diverifikasi')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        return view('dashboard.pengaduan.index', [
            'pengaduans' => $pengaduans,
            'statusFilter' => $request->status,
            'cari' => $request->cari,
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
        ], [
            'petugas_id.required' => 'Pilih petugas yang akan melakukan pengecekan.',
        ]);

        $petugas = User::find($validated['petugas_id']);

        $pengaduan->update([
            'status' => 'pengecekan',
            'petugas_id' => $validated['petugas_id'],
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: {$petugas->name}.",
            'status_baru' => 'pengecekan',
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
            'foto_pengecekan' => ['nullable', 'array', 'max:6'],
            'foto_pengecekan.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'perlu_spkp.required' => 'Pilih apakah perlu SPKP atau tidak.',
            'hasil_pemeriksaan.required' => 'Hasil pemeriksaan wajib diisi.',
            'hasil_pemeriksaan.min' => 'Hasil pemeriksaan minimal 5 karakter.',
            'foto_pengecekan.max' => 'Maksimal 6 foto yang bisa diunggah.',
            'foto_pengecekan.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_pengecekan.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_pengecekan.*.max' => 'Ukuran tiap foto maksimal 5MB.',
        ]);

        $pengaduan->update([
            'status' => 'diverifikasi',
            'perlu_spkp' => $validated['perlu_spkp'],
            'hasil_pemeriksaan' => $validated['hasil_pemeriksaan'],
            'tanggal_pemeriksaan' => now(),
        ]);

        $labelSpkp = $validated['perlu_spkp'] === 'ya' ? 'Perlu SPKP' : 'Tidak Perlu SPKP';
        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan telah diverifikasi. Hasil pemeriksaan: {$validated['hasil_pemeriksaan']} ({$labelSpkp}).",
            'status_baru' => 'diverifikasi',
        ]);

        foreach ($validated['foto_pengecekan'] ?? [] as $file) {
            $path = $file->store('dokumentasi', 'public');
            $tanggapan->fotos()->create(['path' => $path]);
        }

        return back()->with('success', 'Pengaduan berhasil diverifikasi.');
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
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan ditolak. Alasan: {$validated['catatan_penolakan']}",
            'status_baru' => 'ditolak',
        ]);

        return back()->with('success', 'Pengaduan telah ditolak.');
    }

    // DIVERIFIKASI -> DIPROSES (pilih pekerja pelaksana perbaikan)
    public function mulaiProses(Request $request, Pengaduan $pengaduan)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menugaskan pelaksana.');
        abort_unless($pengaduan->status === 'diverifikasi', 422, 'Pengaduan ini bukan status Diverifikasi.');

        $validated = $request->validate([
            'pelaksana_id' => ['required', 'exists:users,id'],
        ], [
            'pelaksana_id.required' => 'Pilih pekerja yang akan melakukan perbaikan.',
        ]);

        $pelaksana = User::find($validated['pelaksana_id']);

        $pengaduan->update([
            'status' => 'diproses',
            'petugas_id' => $validated['pelaksana_id'],
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan mulai dikerjakan oleh: {$pelaksana->name}.",
            'status_baru' => 'diproses',
        ]);

        return back()->with('success', 'Pengaduan mulai diproses.');
    }

    // DIPROSES: catat progres pekerjaan (bisa berkali-kali, status TIDAK berubah)
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

        return back()->with('success', 'Progres pekerjaan berhasil dicatat.');
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
        ]);

        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => $validated['catatan_selesai'],
            'status_baru' => 'selesai',
        ]);

        return back()->with('success', 'Pengaduan telah diselesaikan.');
    }
}