@extends('layouts.dashboard')

@section('title', 'Detail Pengaduan')

@section('content')

    <a href="/dashboard/pengaduan" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-brand-blue transition mb-5">
        ← Kembali ke daftar pengaduan
    </a>

    <div class="grid lg:grid-cols-3 gap-5">

        {{-- ===== KOLOM KIRI: INFO PENGADUAN ===== --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Header --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-5 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">Nomor Pengaduan</p>
                        <p class="font-display font-bold text-lg sm:text-xl text-brand-blue">{{ $pengaduan->kode_pengaduan }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $pengaduan->statusColor() }}">
                        {{ $pengaduan->statusLabel() }}
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 gap-x-4 gap-y-3 mt-5 pt-5 border-t border-slate-100 text-sm">
                    <div>
                        <p class="text-xs text-slate-400">Kategori</p>
                        <p class="text-ink font-medium mt-0.5">{{ $pengaduan->kategori->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Tanggal Masuk</p>
                        <p class="text-ink font-medium mt-0.5">{{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-400">Judul</p>
                        <p class="text-ink font-medium mt-0.5 break-words">{{ $pengaduan->judul }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-400">Deskripsi</p>
                        <p class="text-ink mt-0.5 leading-relaxed break-words">{{ $pengaduan->deskripsi }}</p>
                    </div>
                    @if ($pengaduan->lokasi_kejadian)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-slate-400">Detail Lokasi Kejadian</p>
                            <p class="text-ink mt-0.5 leading-relaxed break-words">{{ $pengaduan->lokasi_kejadian }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Data pelapor --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-5 sm:p-6">
                <p class="font-display font-semibold text-ink mb-4">Data Pelapor</p>
                <div class="grid sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                    <div><p class="text-xs text-slate-400">Nama</p><p class="text-ink font-medium mt-0.5">{{ $pengaduan->nama_pelapor }}</p></div>
                    <div><p class="text-xs text-slate-400">No. HP</p><p class="text-ink font-medium mt-0.5">{{ $pengaduan->no_hp }}</p></div>
                    <div><p class="text-xs text-slate-400">NPA</p><p class="text-ink font-medium mt-0.5">{{ $pengaduan->no_pelanggan ?: '-' }}</p></div>
                    <div><p class="text-xs text-slate-400">Email</p><p class="text-ink font-medium mt-0.5">{{ $pengaduan->email ?: '-' }}</p></div>
                    <div class="sm:col-span-2"><p class="text-xs text-slate-400">Alamat</p><p class="text-ink font-medium mt-0.5 break-words">{{ $pengaduan->alamat }}</p></div>
                    <div class="sm:col-span-2"><p class="text-xs text-slate-400">Patokan Rumah</p><p class="text-ink font-medium mt-0.5">{{ $pengaduan->no_rumah_patokan ?: '-' }}</p></div>
                </div>

                @if ($pengaduan->fotos->count() > 0)
                    <div class="mt-5 pt-5 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-2">Foto Bukti dari Pelapor ({{ $pengaduan->fotos->count() }})</p>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach ($pengaduan->fotos as $foto)
                                <a href="{{ $foto->url() }}" target="_blank">
                                    <img src="{{ $foto->url() }}" class="w-full h-16 sm:h-20 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Hasil pemeriksaan & SPKP (read-only, diisi lewat tombol Verifikasi) --}}
            @if ($pengaduan->hasil_pemeriksaan)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 sm:p-6">
                    <p class="font-display font-semibold text-ink mb-4">Hasil Pemeriksaan Lapangan & SPKP</p>
                    <div class="bg-slate-50 rounded-xl p-4 text-sm">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-xs text-slate-400">Keputusan:</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $pengaduan->perlu_spkp === 'ya' ? 'bg-orange-100 text-orange-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $pengaduan->perluSpkpLabel() }}
                            </span>
                        </div>
                        <p class="text-ink break-words">{{ $pengaduan->hasil_pemeriksaan }}</p>
                        @if ($pengaduan->tanggal_pemeriksaan)
                            <p class="text-xs text-slate-400 mt-1.5">Diperiksa: {{ $pengaduan->tanggal_pemeriksaan->translatedFormat('d F Y, H:i') }} WIB</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Timeline --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-5 sm:p-6">
                <p class="font-display font-semibold text-ink mb-6">Riwayat / Timeline</p>
                <div class="space-y-0">
                    @foreach ($pengaduan->tanggapans as $tanggapan)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="w-3.5 h-3.5 rounded-full {{ $tanggapan->dotColorClass() }} ring-4 ring-white shrink-0 mt-1"></span>
                                @if (!$loop->last)
                                    <span class="w-0.5 flex-1 bg-slate-100 my-1"></span>
                                @endif
                            </div>
                            <div class="pb-6 flex-1">
                                <p class="text-xs text-slate-400">{{ $tanggapan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                <p class="text-sm text-ink mt-1 leading-relaxed break-words">{{ $tanggapan->pesan }}</p>
                                @if ($tanggapan->user)
                                    <p class="text-xs text-slate-400 mt-1">oleh {{ $tanggapan->user->name }}</p>
                                @endif
                                @if ($tanggapan->fotos->count() > 0)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach ($tanggapan->fotos as $foto)
                                            <a href="{{ $foto->url() }}" target="_blank">
                                                <img src="{{ $foto->url() }}" class="h-20 w-20 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ===== KOLOM KANAN: AKSI ===== --}}
        @php
            // Deteksi modal mana yang harus otomatis kebuka lagi kalau validasi server gagal
            $errorModal = null;
            if ($errors->has('petugas_id')) $errorModal = 'pengecekan';
            elseif ($errors->has('perlu_spkp') || $errors->has('hasil_pemeriksaan')) $errorModal = 'verifikasi';
            elseif ($errors->has('catatan_penolakan')) $errorModal = 'tolak';
            elseif ($errors->has('pelaksana_id')) $errorModal = 'proses';
            elseif ($errors->has('catatan_selesai')) $errorModal = 'selesai';
        @endphp

        <div class="space-y-5"
             x-data="{
                activeModal: @js($errorModal),
                fotoV: [],
                fotoL: [],
                addFoto(list, files, refKey) {
                    const arr = Array.from(files || []);
                    if (arr.length === 0) return;
                    if (this[list].length + arr.length > 6) { alert('Maksimal 6 foto yang bisa diunggah.'); return; }
                    arr.forEach((f) => this[list].push({ file: f, previewUrl: URL.createObjectURL(f) }));
                    this.syncInput(list, refKey);
                },
                removeFoto(list, index, refKey) {
                    this[list].splice(index, 1);
                    this.syncInput(list, refKey);
                },
                syncInput(list, refKey) {
                    const dt = new DataTransfer();
                    this[list].forEach((item) => dt.items.add(item.file));
                    this.$refs[refKey].files = dt.files;
                }
             }">

            {{-- ===== KARTU AKSI — kondisional sesuai status saat ini ===== --}}
            @if ($pengaduan->status === 'baru')
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <p class="font-display font-semibold text-ink mb-1">Langkah Selanjutnya</p>
                    <p class="text-xs text-slate-500 mb-4">Pengaduan ini baru masuk. Tugaskan petugas untuk cek ke lokasi.</p>
                    @if (auth()->user()->isAdmin())
                        <button @click="activeModal = 'pengecekan'" class="w-full h-11 rounded-xl bg-brand-blue text-white font-semibold text-sm shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                            Mulai Pengecekan
                        </button>
                    @else
                        <p class="text-xs text-slate-400 italic">Menunggu admin menugaskan petugas pengecekan.</p>
                    @endif
                </div>

            @elseif ($pengaduan->status === 'pengecekan')
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <p class="font-display font-semibold text-ink mb-1">Langkah Selanjutnya</p>
                    <p class="text-xs text-slate-500 mb-4">Petugas sedang/sudah mengecek lokasi. Tentukan hasilnya.</p>
                    <div class="flex gap-2">
                        <button @click="activeModal = 'verifikasi'" class="flex-1 h-11 rounded-xl bg-brand-green text-white font-semibold text-sm shadow-lg shadow-brand-green/30 hover:opacity-90 transition">
                            ✓ Verifikasi
                        </button>
                        <button @click="activeModal = 'tolak'" class="flex-1 h-11 rounded-xl bg-red-500 text-white font-semibold text-sm shadow-lg shadow-red-500/30 hover:bg-red-600 transition">
                            ✕ Tolak
                        </button>
                    </div>
                </div>

            @elseif ($pengaduan->status === 'diverifikasi')
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <p class="font-display font-semibold text-ink mb-1">Langkah Selanjutnya</p>
                    <p class="text-xs text-slate-500 mb-4">Pengaduan sudah diverifikasi. Tugaskan pekerja untuk mulai perbaikan.</p>
                    @if (auth()->user()->isAdmin())
                        <button @click="activeModal = 'proses'" class="w-full h-11 rounded-xl bg-brand-blue text-white font-semibold text-sm shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                            Lanjut ke Proses
                        </button>
                    @else
                        <p class="text-xs text-slate-400 italic">Menunggu admin menugaskan pekerja pelaksana.</p>
                    @endif
                </div>

            @elseif ($pengaduan->status === 'diproses')
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <p class="font-display font-semibold text-ink mb-1">Catat Progres Pekerjaan</p>
                    <p class="text-xs text-slate-500 mb-4">Bisa diisi berkali-kali sampai pekerjaan benar-benar selesai.</p>

                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/log-proses" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <textarea name="pesan" rows="3" required placeholder="Contoh: Sudah bongkar pipa lama, besok lanjut pasang yang baru."
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition resize-none">{{ old('pesan') }}</textarea>

                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-3 text-center"
                             @drop.prevent="addFoto('fotoL', $event.dataTransfer.files, 'fotoLInput')" @dragover.prevent>
                            <button type="button" @click="$refs.fotoLInput.click()" class="text-xs font-semibold text-brand-blue border border-brand-blue/30 rounded-full px-4 py-1.5 hover:bg-brand-blue/5 transition">
                                + Foto Progres
                            </button>
                            <input type="file" name="foto[]" x-ref="fotoLInput" multiple accept="image/jpeg,image/jpg,image/png" class="hidden"
                                   @change="addFoto('fotoL', $event.target.files, 'fotoLInput')">
                        </div>
                        <div class="grid grid-cols-4 gap-2" x-show="fotoL.length > 0">
                            <template x-for="(item, index) in fotoL" :key="index">
                                <div class="relative">
                                    <img :src="item.previewUrl" class="w-full h-16 object-cover rounded-lg border border-slate-200">
                                    <button type="button" @click="removeFoto('fotoL', index, 'fotoLInput')"
                                            class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-md hover:bg-red-600 transition">✕</button>
                                </div>
                            </template>
                        </div>

                        <button type="submit" class="w-full h-11 rounded-xl bg-brand-teal text-white font-semibold text-sm hover:opacity-90 transition">
                            + Tambah Progres
                        </button>
                    </form>
                </div>

                <button @click="activeModal = 'selesai'" class="w-full h-12 rounded-2xl bg-brand-green text-white font-semibold text-sm shadow-lg shadow-brand-green/30 hover:opacity-90 transition">
                    ✓ Selesaikan Pengaduan
                </button>

            @elseif ($pengaduan->status === 'selesai')
                <div class="bg-brand-green/10 border border-brand-green/30 rounded-2xl p-5 text-sm text-brand-green">
                    ✓ Pengaduan telah selesai
                    @if ($pengaduan->tanggal_selesai)
                        pada {{ $pengaduan->tanggal_selesai->translatedFormat('d F Y, H:i') }} WIB
                    @endif
                    .
                </div>

            @elseif ($pengaduan->status === 'ditolak')
                <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-sm text-red-600">
                    <p class="font-semibold mb-1">✕ Pengaduan ditolak</p>
                    <p>{{ $pengaduan->catatan_admin }}</p>
                </div>
            @endif

            {{-- Link surat --}}
            <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat" target="_blank" class="flex items-center justify-center gap-2 bg-white border border-slate-200 rounded-2xl p-4 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition">
                🖨️ Lihat Surat Pengaduan
            </a>

            {{-- ===== MODAL-MODAL ===== --}}
            <div x-show="activeModal !== null" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
                <div class="absolute inset-0 bg-black/40" @click="activeModal = null"></div>

                {{-- Modal: Mulai Pengecekan --}}
                <div x-show="activeModal === 'pengecekan'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                    <p class="font-display font-bold text-lg text-ink mb-1">Mulai Pengecekan</p>
                    <p class="text-sm text-slate-500 mb-4">Pilih petugas yang akan turun ke lokasi.</p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/mulai-pengecekan">
                        @csrf
                        <select name="petugas_id" class="w-full h-11 rounded-xl border {{ $errors->has('petugas_id') ? 'border-red-400' : 'border-slate-200' }} px-3 text-sm mb-1 bg-white focus:ring-2 focus:ring-brand-blue outline-none">
                            <option value="" disabled selected>Pilih petugas</option>
                            @foreach ($petugasList as $petugas)
                                <option value="{{ $petugas->id }}" {{ old('petugas_id') == $petugas->id ? 'selected' : '' }}>{{ $petugas->name }}</option>
                            @endforeach
                        </select>
                        @error('petugas_id')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror
                        <div class="flex gap-2 mt-3">
                            <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Mulai Pengecekan</button>
                        </div>
                    </form>
                </div>

                {{-- Modal: Verifikasi --}}
                <div x-show="activeModal === 'verifikasi'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto" style="display:none">
                    <p class="font-display font-bold text-lg text-ink mb-1">Verifikasi Pengaduan</p>
                    <p class="text-sm text-slate-500 mb-4">Isi hasil pengecekan lapangan.</p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/verifikasi" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Perlu SPKP?</label>
                            <div class="flex gap-3">
                                <label class="flex items-center gap-2 text-sm"><input type="radio" name="perlu_spkp" value="ya" class="accent-brand-blue" {{ old('perlu_spkp') === 'ya' ? 'checked' : '' }}> Ya</label>
                                <label class="flex items-center gap-2 text-sm"><input type="radio" name="perlu_spkp" value="tidak" class="accent-brand-blue" {{ old('perlu_spkp') === 'tidak' ? 'checked' : '' }}> Tidak</label>
                            </div>
                            @error('perlu_spkp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Hasil Pemeriksaan</label>
                            <textarea name="hasil_pemeriksaan" rows="3" placeholder="Ceritakan temuan di lokasi..."
                                      class="w-full rounded-xl border {{ $errors->has('hasil_pemeriksaan') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none focus:ring-2 focus:ring-brand-blue outline-none">{{ old('hasil_pemeriksaan') }}</textarea>
                            @error('hasil_pemeriksaan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Foto Pengecekan <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                            <div class="border-2 border-dashed border-slate-200 rounded-xl p-3 text-center" @drop.prevent="addFoto('fotoV', $event.dataTransfer.files, 'fotoVInput')" @dragover.prevent>
                                <button type="button" @click="$refs.fotoVInput.click()" class="text-xs font-semibold text-brand-blue border border-brand-blue/30 rounded-full px-4 py-1.5 hover:bg-brand-blue/5 transition">Pilih File</button>
                                <input type="file" name="foto_pengecekan[]" x-ref="fotoVInput" multiple accept="image/jpeg,image/jpg,image/png" class="hidden" @change="addFoto('fotoV', $event.target.files, 'fotoVInput')">
                            </div>
                            <div class="grid grid-cols-4 gap-2 mt-2" x-show="fotoV.length > 0">
                                <template x-for="(item, index) in fotoV" :key="index">
                                    <div class="relative">
                                        <img :src="item.previewUrl" class="w-full h-14 object-cover rounded-lg border border-slate-200">
                                        <button type="button" @click="removeFoto('fotoV', index, 'fotoVInput')" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-md hover:bg-red-600 transition">✕</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-green text-white text-sm font-semibold hover:opacity-90 transition">Verifikasi</button>
                        </div>
                    </form>
                </div>

                {{-- Modal: Tolak --}}
                <div x-show="activeModal === 'tolak'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                    <p class="font-display font-bold text-lg text-ink mb-1">Tolak Pengaduan</p>
                    <p class="text-sm text-slate-500 mb-4">Jelaskan alasan penolakan — akan dikirim ke pelanggan.</p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/tolak">
                        @csrf
                        <textarea name="catatan_penolakan" rows="4" placeholder="Contoh: Setelah dicek, tidak ditemukan kerusakan pada instalasi PDAM."
                                  class="w-full rounded-xl border {{ $errors->has('catatan_penolakan') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none mb-1 focus:ring-2 focus:ring-brand-blue outline-none">{{ old('catatan_penolakan') }}</textarea>
                        @error('catatan_penolakan')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror
                        <div class="flex gap-2 mt-3">
                            <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">Tolak Pengaduan</button>
                        </div>
                    </form>
                </div>

                {{-- Modal: Mulai Proses --}}
                <div x-show="activeModal === 'proses'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                    <p class="font-display font-bold text-lg text-ink mb-1">Lanjut ke Proses</p>
                    <p class="text-sm text-slate-500 mb-4">Pilih pekerja yang akan melakukan perbaikan.</p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/mulai-proses">
                        @csrf
                        <select name="pelaksana_id" class="w-full h-11 rounded-xl border {{ $errors->has('pelaksana_id') ? 'border-red-400' : 'border-slate-200' }} px-3 text-sm mb-1 bg-white focus:ring-2 focus:ring-brand-blue outline-none">
                            <option value="" disabled selected>Pilih pekerja</option>
                            @foreach ($petugasList as $petugas)
                                <option value="{{ $petugas->id }}" {{ old('pelaksana_id') == $petugas->id ? 'selected' : '' }}>{{ $petugas->name }}</option>
                            @endforeach
                        </select>
                        @error('pelaksana_id')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror
                        <div class="flex gap-2 mt-3">
                            <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">Mulai Proses</button>
                        </div>
                    </form>
                </div>

                {{-- Modal: Selesai --}}
                <div x-show="activeModal === 'selesai'" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" style="display:none">
                    <p class="font-display font-bold text-lg text-ink mb-1">Selesaikan Pengaduan</p>
                    <p class="text-sm text-slate-500 mb-4">Tulis catatan penutup untuk pelanggan.</p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/selesai">
                        @csrf
                        <textarea name="catatan_selesai" rows="4" placeholder="Contoh: Perbaikan pipa telah selesai dilakukan, air sudah mengalir normal kembali."
                                  class="w-full rounded-xl border {{ $errors->has('catatan_selesai') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none mb-1 focus:ring-2 focus:ring-brand-blue outline-none">{{ old('catatan_selesai') }}</textarea>
                        @error('catatan_selesai')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror
                        <div class="flex gap-2 mt-3">
                            <button type="button" @click="activeModal = null" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-green text-white text-sm font-semibold hover:opacity-90 transition">Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection