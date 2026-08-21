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

        // Hitung per status buat tab filter (tetap dihitung dari semua data, bukan hasil filter)
        $jumlahPerStatus = [
            'semua' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
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

    // Tambah tanggapan, opsional sekalian ubah status
    public function tanggapan(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'pesan' => ['required', 'string', 'min:5'],
            'status_baru' => ['nullable', 'in:baru,pengecekan,diverifikasi,diproses,selesai,ditolak'],
            'foto_dokumentasi' => ['nullable', 'array', 'max:6'],
            'foto_dokumentasi.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'pesan.required' => 'Isi tanggapan wajib diisi.',
            'pesan.min' => 'Tanggapan minimal 5 karakter.',
            'foto_dokumentasi.max' => 'Maksimal 6 foto yang bisa diunggah.',
            'foto_dokumentasi.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_dokumentasi.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_dokumentasi.*.max' => 'Ukuran tiap foto maksimal 5MB.',
        ]);

        $fotoFiles = $validated['foto_dokumentasi'] ?? [];

        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => $validated['pesan'],
            'status_baru' => $validated['status_baru'] ?? null,
        ]);

        foreach ($fotoFiles as $file) {
            $path = $file->store('dokumentasi', 'public');
            $tanggapan->fotos()->create(['path' => $path]);
        }

        if (!empty($validated['status_baru'])) {
            $pengaduan->update([
                'status' => $validated['status_baru'],
                'tanggal_selesai' => $validated['status_baru'] === 'selesai' ? now() : $pengaduan->tanggal_selesai,
            ]);
        }

        return back()->with('success', 'Tanggapan berhasil ditambahkan.');
    }

    // Assign petugas ke pengaduan (khusus admin)
    public function assign(Request $request, Pengaduan $pengaduan)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa menugaskan petugas.');
        }

        $validated = $request->validate([
            'petugas_id' => ['required', 'exists:users,id'],
        ], [
            'petugas_id.required' => 'Pilih petugas terlebih dahulu.',
        ]);

        $pengaduan->update(['petugas_id' => $validated['petugas_id']]);

        $namaPetugas = User::find($validated['petugas_id'])->name;
        $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'pesan' => "Pengaduan ditugaskan ke petugas: {$namaPetugas}.",
        ]);

        return back()->with('success', 'Petugas berhasil ditugaskan.');
    }

    // Simpan hasil pemeriksaan lapangan + keputusan SPKP
    public function pemeriksaan(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'perlu_spkp' => ['required', 'in:ya,tidak'],
            'hasil_pemeriksaan' => ['required', 'string', 'min:5'],
        ], [
            'perlu_spkp.required' => 'Pilih apakah perlu SPKP atau tidak.',
            'hasil_pemeriksaan.required' => 'Hasil pemeriksaan wajib diisi.',
            'hasil_pemeriksaan.min' => 'Hasil pemeriksaan minimal 5 karakter.',
        ]);

        // Method ini sudah ada di Model Pengaduan sejak awal —
        // otomatis catat ke timeline & tandai kalau ini koreksi dari pemeriksaan sebelumnya.
        $pengaduan->updatePemeriksaan(
            $validated['perlu_spkp'],
            $validated['hasil_pemeriksaan'],
            auth()->id()
        );

        return back()->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }
}
