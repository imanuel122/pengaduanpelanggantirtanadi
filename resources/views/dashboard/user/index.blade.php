@extends('layouts.dashboard')

@section('title', 'Manajemen User/Petugas')

@php
    // Tentukan modal mana yang harus otomatis terbuka lagi kalau ada error validasi
    // (misalnya submit form Tambah/Edit tapi datanya tidak valid).
    $errorModal = null;
    if ($errors->any()) {
        $errorModal = old('_form') === 'edit' ? 'edit:' . old('_edit_id') : 'tambah';
    }
@endphp

@section('content')

    <div
        x-data="{
            activeModal: @js($errorModal),
            editData: { id: @js(old('_edit_id')), name: @js(old('name')), nipp: @js(old('nipp')), email: @js(old('email')), phone: @js(old('phone')), role: @js(old('role')) ?? 'petugas' },
            deleteInfo: { id: null, name: '', jumlah: 0, isSelf: false },
            detailData: { id: null },
        }"
    >
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <p class="font-display font-semibold text-lg text-ink">Manajemen User/Petugas</p>
                <p class="text-sm text-slate-500">Kelola akun pegawai (admin & petugas) yang bisa login ke dashboard ini.</p>
            </div>
            <button @click="activeModal = 'tambah'; editData = { id: null, name: '', nipp: '', email: '', phone: '', role: 'petugas' }"
                    class="h-11 px-5 rounded-xl bg-brand-blue text-white text-sm font-semibold shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                + Tambah Akun
            </button>
        </div>

        {{-- Pencarian --}}
        <form method="GET" action="/dashboard/user" class="flex gap-2 mb-5">
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama, NIPP, atau email..."
                   class="flex-1 h-11 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition bg-white">
            <button type="submit" class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 transition">
                Cari
            </button>
        </form>

        {{-- Daftar user --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="divide-y divide-slate-50">
                @forelse ($users as $user)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 justify-between px-4 sm:px-5 py-4">
                        <div class="min-w-0 flex-1 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center text-brand-blue font-display font-bold text-sm shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="font-semibold text-ink truncate">{{ $user->name }}</p>
                                    @if ($user->role === 'admin')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-blue/10 text-brand-blue">Admin</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">Petugas</span>
                                    @endif
                                    @if ($user->id === auth()->id())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-green/10 text-brand-green">Anda</span>
                                    @endif
                                </div>
                                <p class="text-sm text-slate-500 truncate">NIPP: {{ $user->nipp ?? '-' }} &middot; {{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button
                                @click="activeModal = 'detail:{{ $user->id }}'; detailData = { id: {{ $user->id }}, name: @js($user->name), nipp: @js($user->nipp), email: @js($user->email), phone: @js($user->phone), role: @js($user->role), created: @js($user->created_at?->translatedFormat('d F Y')) }"
                                class="h-9 px-4 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition">
                                Detail
                            </button>
                            <button
                                @click="activeModal = 'edit:{{ $user->id }}'; editData = { id: {{ $user->id }}, name: @js($user->name), nipp: @js($user->nipp), email: @js($user->email), phone: @js($user->phone), role: @js($user->role) }"
                                class="h-9 px-4 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition">
                                Edit
                            </button>
                            <button
                                @click="activeModal = 'hapus:{{ $user->id }}'; deleteInfo = { id: {{ $user->id }}, name: @js($user->name), jumlah: {{ $user->pengaduans_ditangani_count }}, isSelf: {{ $user->id === auth()->id() ? 'true' : 'false' }} }"
                                class="h-9 px-4 rounded-lg border border-red-200 text-xs font-semibold text-red-500 hover:bg-red-50 transition">
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-sm text-slate-400">
                        @if ($cari !== '')
                            Tidak ada akun dengan kata kunci "{{ $cari }}".
                        @else
                            Belum ada akun pegawai. Klik "+ Tambah Akun" untuk membuat yang pertama.
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ===== MODAL-MODAL ===== --}}
        <div x-show="activeModal !== null" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
            <div class="absolute inset-0 bg-black/40" @click="activeModal = null"></div>

            {{-- Modal: Tambah Akun --}}
            <div x-show="activeModal === 'tambah'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto" style="display:none">
                <p class="font-display font-bold text-lg text-ink mb-1">Tambah Akun Pegawai</p>
                <p class="text-sm text-slate-500 mb-4">Akun ini akan bisa login ke dashboard menggunakan NIPP & password yang dibuat.</p>
                <form method="POST" action="/dashboard/user">
                    @csrf
                    <input type="hidden" name="_form" value="tambah">

                    <label class="block text-sm font-medium text-ink mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('_form') === 'tambah' ? old('name') : '' }}" placeholder="Contoh: Budi Santoso"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('name')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">NIPP</label>
                    <input type="text" name="nipp" value="{{ old('_form') === 'tambah' ? old('nipp') : '' }}" placeholder="Nomor Induk Pegawai"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('nipp') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('nipp')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Email</label>
                    <input type="email" name="email" value="{{ old('_form') === 'tambah' ? old('email') : '' }}" placeholder="nama@pdamtirtanadi.test"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('email')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">No. Telepon <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                    <input type="text" name="phone" value="{{ old('_form') === 'tambah' ? old('phone') : '' }}" placeholder="08xxxxxxxxxx"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('phone') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('phone')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Role</label>
                    <select name="role" class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('role') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none bg-white">
                        <option value="petugas" {{ old('role', 'petugas') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @if ($errorModal === 'tambah') @error('role')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                           class="w-full h-11 rounded-xl border {{ $errorModal === 'tambah' && $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @if ($errorModal === 'tambah') @error('password')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror @endif

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                           class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">

                    <div class="flex gap-2 mt-4">
                        <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Simpan</button>
                    </div>
                </form>
            </div>

            {{-- Modal: Edit Akun --}}
            <div x-show="activeModal === 'edit:' + editData.id" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto" style="display:none">
                <p class="font-display font-bold text-lg text-ink mb-1">Edit Akun Pegawai</p>
                <p class="text-sm text-slate-500 mb-4">Kosongkan password kalau tidak ingin menggantinya.</p>
                <form method="POST" :action="'/dashboard/user/' + editData.id">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">
                    <input type="hidden" name="_edit_id" :value="editData.id">

                    <label class="block text-sm font-medium text-ink mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" x-model="editData.name"
                           class="w-full h-11 rounded-xl border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('name')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">NIPP</label>
                    <input type="text" name="nipp" x-model="editData.nipp"
                           class="w-full h-11 rounded-xl border {{ $errors->has('nipp') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('nipp')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Email</label>
                    <input type="email" name="email" x-model="editData.email"
                           class="w-full h-11 rounded-xl border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('email')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">No. Telepon <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                    <input type="text" name="phone" x-model="editData.phone"
                           class="w-full h-11 rounded-xl border {{ $errors->has('phone') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('phone')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Role</label>
                    <select name="role" x-model="editData.role" class="w-full h-11 rounded-xl border {{ $errors->has('role') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none bg-white">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Password Baru <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti"
                           class="w-full h-11 rounded-xl border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">
                    @error('password')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror

                    <label class="block text-sm font-medium text-ink mb-1.5 mt-3">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                           class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm mb-1 focus:ring-2 focus:ring-brand-blue outline-none">

                    <div class="flex gap-2 mt-4">
                        <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- Modal: Detail Akun (read-only, dari tabel daftar user) --}}
            <div x-show="activeModal === 'detail:' + detailData.id" class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" style="display:none">
                <p class="font-display font-bold text-lg text-ink mb-4">Detail Akun</p>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-400">Nama Lengkap</p>
                        <p class="font-medium text-ink" x-text="detailData.name"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">NIPP</p>
                        <p class="font-medium text-ink" x-text="detailData.nipp || '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Email</p>
                        <p class="font-medium text-ink" x-text="detailData.email"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">No. Telepon</p>
                        <p class="font-medium text-ink" x-text="detailData.phone || '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Role</p>
                        <p class="font-medium text-ink capitalize" x-text="detailData.role"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Bergabung Sejak</p>
                        <p class="font-medium text-ink" x-text="detailData.created || '-'"></p>
                    </div>
                </div>
                <button type="button" @click="activeModal = null" class="w-full h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition mt-5">
                    Tutup
                </button>
            </div>

            {{-- Modal: Konfirmasi Hapus --}}
            <div x-show="activeModal === 'hapus:' + deleteInfo.id" class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" style="display:none">
                <div class="w-11 h-11 rounded-full bg-red-50 flex items-center justify-center mb-3">
                    <span class="text-xl">🗑️</span>
                </div>
                <p class="font-display font-bold text-lg text-ink mb-1.5">Hapus Akun?</p>

                <template x-if="deleteInfo.isSelf">
                    <p class="text-sm text-red-500 mb-5 leading-relaxed">
                        Anda tidak bisa menghapus akun Anda sendiri yang sedang login.
                    </p>
                </template>
                <template x-if="!deleteInfo.isSelf && deleteInfo.jumlah > 0">
                    <p class="text-sm text-red-500 mb-5 leading-relaxed">
                        Akun "<span x-text="deleteInfo.name" class="font-semibold"></span>" masih tercatat menangani
                        <span x-text="deleteInfo.jumlah" class="font-semibold"></span> pengaduan, jadi tidak bisa dihapus.
                    </p>
                </template>
                <template x-if="!deleteInfo.isSelf && deleteInfo.jumlah === 0">
                    <p class="text-sm text-slate-500 mb-5 leading-relaxed">
                        Akun "<span x-text="deleteInfo.name" class="font-semibold text-ink"></span>" akan dihapus permanen dan tidak akan bisa login lagi. Tindakan ini tidak bisa dibatalkan.
                    </p>
                </template>

                <div class="flex gap-2">
                    <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <template x-if="!deleteInfo.isSelf && deleteInfo.jumlah === 0">
                        <form method="POST" :action="'/dashboard/user/' + deleteInfo.id" class="flex-1">
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
