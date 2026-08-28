<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Semua pegawai (admin & petugas) boleh LIHAT daftar kategori.
    // Tambah/ubah/hapus dibatasi khusus admin (dicek di masing-masing method di bawah).
    public function index(Request $request)
    {
        $cari = trim((string) $request->query('cari', ''));

        $kategoris = KategoriPengaduan::withCount('pengaduans')
            ->when($cari !== '', fn ($q) => $q->where('nama', 'like', "%{$cari}%"))
            ->orderBy('nama')
            ->get();

        return view('dashboard.kategori.index', [
            'kategoris' => $kategoris,
            'cari' => $cari,
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menambah kategori.');

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategori_pengaduans,nama'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori ini sudah ada, coba nama lain.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        KategoriPengaduan::create($validated);

        return back()->with('success', 'Kategori "' . $validated['nama'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriPengaduan $kategori)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa mengubah kategori.');

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategori_pengaduans,nama,' . $kategori->id],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori ini sudah ada, coba nama lain.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        $kategori->update($validated);

        return back()->with('success', 'Kategori "' . $validated['nama'] . '" berhasil diperbarui.');
    }

    public function destroy(KategoriPengaduan $kategori)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menghapus kategori.');

        // Kategori yang masih dipakai pengaduan gak boleh dihapus -- selain bakal
        // gagal karena foreign key constraint, ini juga bisa bikin data pengaduan
        // lama jadi "yatim" (kehilangan info kategorinya).
        $jumlahDipakai = $kategori->pengaduans()->count();
        if ($jumlahDipakai > 0) {
            return back()->with('error', 'Kategori "' . $kategori->nama . '" tidak bisa dihapus karena masih dipakai di ' . $jumlahDipakai . ' pengaduan.');
        }

        $nama = $kategori->nama;
        $kategori->delete();

        return back()->with('success', 'Kategori "' . $nama . '" berhasil dihapus.');
    }
}
