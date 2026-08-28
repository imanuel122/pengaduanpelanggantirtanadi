@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')

@php
    // Tentukan modal mana yang harus otomatis terbuka lagi kalau ada error validasi
    // (misalnya submit form Tambah/Edit tapi nama kategorinya kosong/duplikat).
    $errorModal = null;
    if ($errors->any()) {
        $errorModal = old('_form') === 'edit' ? 'edit:' . old('_edit_id') : 'tambah';
    }
@endphp

@section('content')

    <div
        x-data="{
            activeModal: @js($errorModal),
            editData: { id: @js(old('_edit_id')), nama: @js(old('nama')), deskripsi: @js(old('deskripsi')) },
            deleteInfo: { id: null, nama: '', jumlah: 0 },
        }"
    >
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <p class="font-display font-semibold text-lg text-ink">Kategori Pengaduan</p>
                <p class="text-sm text-slate-500">Kelola daftar kategori yang muncul di form pengaduan pelanggan.</p>
            </div>
            @if (auth()->user()->isAdmin())
                <button @click="activeModal = 'tambah'" class="h-11 px-5 rounded-xl bg-brand-blue text-white text-sm font-semibold shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                    + Tambah Kategori
                </button>
            @endif
        </div>

        {{-- Pencarian --}}
        <form method="GET" action="/dashboard/kategori" class="flex gap-2 mb-5">
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama kategori..."
                   class="flex-1 h-11 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition bg-white">
            <button type="submit" class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 transition">
                Cari
            </button>
        </form>

        {{-- Daftar kategori --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="divide-y divide-slate-50">
                @forelse ($kategoris as $kategori)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 justify-between px-4 sm:px-5 py-4">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-semibold text-ink">{{ $kategori->nama }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                    {{ $kategori->pengaduans_count }} pengaduan
                                </span>
                            </div>
                            @if ($kategori->deskripsi)
                                <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $kategori->deskripsi }}</p>
                            @else
                                <p class="text-sm text-slate-300 mt-1 italic">Tidak ada deskripsi</p>
                            @endif
                        </div>

                        @if (auth()->user()->isAdmin())
                            <div class="flex items-center gap-2 shrink-0">
                                <button
                                    @click="activeModal = 'edit:{{ $kategori->id }}'; editData = { id: {{ $kategori->id }}, nama: @js($kategori->nama), deskripsi: @js($kategori->deskripsi) }"
                                    class="h-9 px-4 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition">
                                    Edit
                                </button>
                                <button
                                    @click="activeModal = 'hapus:{{ $kategori->id }}'; deleteInfo = { id: {{ $kategori->id }}, nama: @js($kategori->nama), jumlah: {{ $kategori->pengaduans_count }} }"
                                    class="h-9 px-4 rounded-lg border border-red-200 text-xs font-semibold text-red-500 hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-sm text-slate-400">
                        @if ($cari !== '')
                            Tidak ada kategori dengan nama "{{ $cari }}".
                        @else
                            Belum ada kategori pengaduan. Klik "+ Tambah Kategori" untuk membuat yang pertama.
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ===== MODAL-MODAL ===== --}}
        <div x-show="activeModal !== null" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
            <div class="absolute inset-0 bg-black/40" @click="activeModal = null"></div>

            {{-- Modal: Tambah Kategori --}}
            <div x-show="activeModal === 'tambah'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                <p class="font-display font-bold text-lg text-ink mb-1">Tambah Kategori</p>
                <p class="text-sm text-slate-500 mb-4">Kategori baru akan langsung muncul di form pengaduan pelanggan.</p>
                <form method="POST" action="/dashboard/kategori">
                    @csrf
                    <input type="hidden" name="_form" value="tambah">

                    <label class="block text-sm font-medium text-ink mb-1.5">Nama Kategori</label>
                    <input type="text" name="nama" value="{{ old('_form') === 'tambah' ? old('nama') : '' }}" placeholder="Contoh: Air Keruh"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('nama') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('nama')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Deskripsi <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan singkat kategori ini mencakup keluhan seperti apa..."
                              class="w-full rounded-xl border {{ $errorModal === 'tambah' && $errors->has('deskripsi') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none mb-1 focus:ring-2 focus:ring-brand-blue outline-none">{{ old('_form') === 'tambah' ? old('deskripsi') : '' }}</textarea>
                    @if ($errorModal === 'tambah') @error('deskripsi')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <div class="flex gap-2 mt-4">
                        <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Simpan</button>
                    </div>
                </form>
            </div>

            {{-- Modal: Edit Kategori --}}
            <div x-show="activeModal === 'edit:' + editData.id" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                <p class="font-display font-bold text-lg text-ink mb-1">Edit Kategori</p>
                <p class="text-sm text-slate-500 mb-4">Perubahan nama akan langsung terlihat di form pengaduan pelanggan.</p>
                <form method="POST" :action="'/dashboard/kategori/' + editData.id">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">
                    <input type="hidden" name="_edit_id" :value="editData.id">

                    <label class="block text-sm font-medium text-ink mb-1.5">Nama Kategori</label>
                    <input type="text" name="nama" x-model="editData.nama"
                           class="w-full h-11 rounded-xl border {{ $errors->has('nama') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('nama')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Deskripsi <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                    <textarea name="deskripsi" rows="3" x-model="editData.deskripsi"
                              class="w-full rounded-xl border {{ $errors->has('deskripsi') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none mb-1 focus:ring-2 focus:ring-brand-blue outline-none"></textarea>
                    @error('deskripsi')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <div class="flex gap-2 mt-4">
                        <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- Modal: Konfirmasi Hapus --}}
            <div x-show="activeModal === 'hapus:' + deleteInfo.id" class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" style="display:none">
                <div class="w-11 h-11 rounded-full bg-red-50 flex items-center justify-center mb-3">
                    <span class="text-xl">🗑️</span>
                </div>
                <p class="font-display font-bold text-lg text-ink mb-1.5">Hapus Kategori?</p>

                <template x-if="deleteInfo.jumlah > 0">
                    <p class="text-sm text-red-500 mb-5 leading-relaxed">
                        Kategori "<span x-text="deleteInfo.nama" class="font-semibold"></span>" masih dipakai di
                        <span x-text="deleteInfo.jumlah" class="font-semibold"></span> pengaduan, jadi tidak bisa dihapus.
                        Hapus/ubah dulu pengaduan yang memakainya, atau biarkan kategori ini tetap ada.
                    </p>
                </template>
                <template x-if="deleteInfo.jumlah === 0">
                    <p class="text-sm text-slate-500 mb-5 leading-relaxed">
                        Kategori "<span x-text="deleteInfo.nama" class="font-semibold text-ink"></span>" akan dihapus permanen dan tidak akan muncul lagi di form pengaduan. Tindakan ini tidak bisa dibatalkan.
                    </p>
                </template>

                <div class="flex gap-2">
                    <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <template x-if="deleteInfo.jumlah === 0">
                        <form method="POST" :action="'/dashboard/kategori/' + deleteInfo.id" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-11 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                                Ya, Hapus
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>

@endsection
