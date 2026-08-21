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

            {{-- Hasil pemeriksaan & SPKP --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-5 sm:p-6">
                <p class="font-display font-semibold text-ink mb-1">Pemeriksaan Lapangan & SPKP</p>
                <p class="text-xs text-slate-500 mb-4">
                    Isi setelah petugas mengecek lokasi. Bisa diperbarui lagi kalau ternyata keputusan awal perlu dikoreksi.
                </p>

                @if ($pengaduan->perlu_spkp)
                    <div class="bg-slate-50 rounded-xl p-4 mb-4 text-sm">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-xs text-slate-400">Status saat ini:</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $pengaduan->perlu_spkp === 'ya' ? 'bg-orange-100 text-orange-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $pengaduan->perluSpkpLabel() }}
                            </span>
                        </div>
                        <p class="text-ink break-words">{{ $pengaduan->hasil_pemeriksaan }}</p>
                        @if ($pengaduan->tanggal_pemeriksaan)
                            <p class="text-xs text-slate-400 mt-1.5">Diperiksa: {{ $pengaduan->tanggal_pemeriksaan->translatedFormat('d F Y, H:i') }} WIB</p>
                        @endif
                    </div>
                @endif

                <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/pemeriksaan" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Perlu SPKP?</label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="perlu_spkp" value="ya" class="accent-brand-blue" {{ old('perlu_spkp', $pengaduan->perlu_spkp) === 'ya' ? 'checked' : '' }}>
                                Ya, perlu SPKP
                            </label>
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="perlu_spkp" value="tidak" class="accent-brand-blue" {{ old('perlu_spkp', $pengaduan->perlu_spkp) === 'tidak' ? 'checked' : '' }}>
                                Tidak perlu
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Hasil Pemeriksaan</label>
                        <textarea name="hasil_pemeriksaan" rows="2" placeholder="Ceritakan temuan di lokasi..."
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition resize-none">{{ old('hasil_pemeriksaan') }}</textarea>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-teal text-white font-semibold rounded-xl px-5 py-2.5 text-sm hover:opacity-90 transition">
                        Simpan Hasil Pemeriksaan
                    </button>
                </form>
            </div>

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
        <div class="space-y-5">

            {{-- Assign petugas (admin only) --}}
            @if (auth()->user()->isAdmin())
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <p class="font-display font-semibold text-ink mb-1">Assign Petugas</p>
                    <p class="text-xs text-slate-500 mb-4">
                        @if ($pengaduan->petugas)
                            Saat ini ditangani: <span class="font-semibold text-ink">{{ $pengaduan->petugas->name }}</span>
                        @else
                            Belum ada petugas yang ditugaskan.
                        @endif
                    </p>
                    <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/assign" class="flex flex-col gap-2">
                        @csrf
                        <select name="petugas_id" required class="w-full h-11 rounded-xl border border-slate-200 px-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition bg-white">
                            <option value="" disabled selected>Pilih petugas</option>
                            @foreach ($petugasList as $petugas)
                                <option value="{{ $petugas->id }}" {{ $pengaduan->petugas_id === $petugas->id ? 'selected' : '' }}>{{ $petugas->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="h-11 rounded-xl bg-brand-blue text-white font-semibold text-sm hover:bg-brand-bluelight transition">
                            Tugaskan
                        </button>
                    </form>
                </div>
            @endif

            {{-- Tambah tanggapan / ubah status --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-5"
                 x-data="{
                    dragging: false,
                    fotoFiles: [],
                    handleFoto(fileList) {
                        const filesArray = Array.from(fileList || []);
                        if (filesArray.length === 0) return;
                        if (this.fotoFiles.length + filesArray.length > 6) {
                            alert('Maksimal 6 foto yang bisa diunggah.');
                            return;
                        }
                        filesArray.forEach((file) => {
                            this.fotoFiles.push({ file: file, previewUrl: URL.createObjectURL(file), name: file.name });
                        });
                        this.syncFotoInput();
                    },
                    removeFoto(index) {
                        this.fotoFiles.splice(index, 1);
                        this.syncFotoInput();
                    },
                    syncFotoInput() {
                        const dataTransfer = new DataTransfer();
                        this.fotoFiles.forEach((item) => dataTransfer.items.add(item.file));
                        this.$refs.fotoInput.files = dataTransfer.files;
                    }
                 }">
                <p class="font-display font-semibold text-ink mb-1">Tambah Tanggapan</p>
                <p class="text-xs text-slate-500 mb-4">Akan muncul di timeline & bisa dilihat pelanggan di halaman Lacak Pengaduan.</p>

                <form method="POST" action="/dashboard/pengaduan/{{ $pengaduan->id }}/tanggapan" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Isi Tanggapan</label>
                        <textarea name="pesan" rows="3" required placeholder="Tulis update terbaru untuk pelanggan..."
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition resize-none">{{ old('pesan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">
                            Ubah Status <span class="text-slate-400 font-normal text-xs">— opsional</span>
                        </label>
                        <select name="status_baru" class="w-full h-11 rounded-xl border border-slate-200 px-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition bg-white">
                            <option value="">Jangan ubah status</option>
                            <option value="baru" {{ $pengaduan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="pengecekan" {{ $pengaduan->status === 'pengecekan' ? 'selected' : '' }}>Pengecekan</option>
                            <option value="diverifikasi" {{ $pengaduan->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1.5">Alur: Baru → Pengecekan → Diverifikasi/Ditolak → Diproses → Selesai</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">
                            Foto Dokumentasi <span class="text-slate-400 font-normal text-xs">— opsional, bisa lebih dari 1</span>
                        </label>

                        <div class="border-2 border-dashed rounded-xl p-4 text-center transition-colors"
                             :class="dragging ? 'border-brand-blue bg-brand-blue/5' : 'border-slate-200'"
                             @dragover.prevent="dragging = true"
                             @dragleave.prevent="dragging = false"
                             @drop.prevent="dragging = false; handleFoto($event.dataTransfer.files)">
                            <p class="text-xs text-slate-500">Tarik & lepas foto, atau</p>
                            <button type="button" @click="$refs.fotoInput.click()"
                                    class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-brand-blue border border-brand-blue/30 rounded-full px-4 py-1.5 hover:bg-brand-blue/5 transition">
                                Pilih File
                            </button>
                            <input type="file" name="foto_dokumentasi[]" x-ref="fotoInput" accept="image/jpeg,image/jpg,image/png" multiple class="hidden"
                                   @change="handleFoto($event.target.files)">
                        </div>

                        <div class="grid grid-cols-4 gap-2 mt-3" x-show="fotoFiles.length > 0">
                            <template x-for="(item, index) in fotoFiles" :key="index">
                                <div class="relative">
                                    <img :src="item.previewUrl" class="w-full h-16 object-cover rounded-lg border border-slate-200">
                                    <button type="button" @click="removeFoto(index)"
                                            class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-md hover:bg-red-600 transition">
                                        ✕
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <button type="submit" class="w-full h-11 rounded-xl bg-brand-blue text-white font-semibold text-sm shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                        Kirim Tanggapan
                    </button>
                </form>
            </div>

            {{-- Link surat --}}
            <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat" target="_blank" class="flex items-center justify-center gap-2 bg-white border border-slate-200 rounded-2xl p-4 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition">
                🖨️ Lihat Surat Pengaduan
            </a>

        </div>
    </div>

@endsection
