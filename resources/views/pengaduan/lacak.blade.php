@extends('layouts.app')

@section('title', 'Lacak Pengaduan — PDAM Tirtanadi Padang Bulan')
@section('meta_description', 'Pantau perkembangan status pengaduan Anda menggunakan nomor pengaduan.')

@section('content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-16">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-400 mb-6">
        <a href="/" class="hover:text-brand-blue transition">Beranda</a>
        <span>/</span>
        <span class="text-slate-600 font-medium">Lacak Pengaduan</span>
    </div>

    {{-- Header halaman --}}
    <div class="mb-8 sm:mb-10">
        <span class="inline-flex items-center gap-2 bg-brand-teal/10 text-brand-teal text-xs font-semibold px-4 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-brand-lime"></span> Pantau Status Pengaduan
        </span>
        <h1 class="font-display font-extrabold text-2xl sm:text-4xl text-ink mt-4 leading-tight">
            Lacak Pengaduan Anda
        </h1>
        <p class="text-slate-600 mt-2 text-sm sm:text-base max-w-xl">
            Cari pakai nomor pengaduan yang Anda terima saat mengirim laporan,
            atau cari pakai nama, nomor HP, atau nomor pelanggan (NPA) Anda
            untuk melihat semua pengaduan yang pernah dibuat.
        </p>
    </div>

    {{-- Form pencarian, dengan 2 tab: nomor pengaduan / nama-hp-npa --}}
    <div x-data="{ mode: @js($cariDicari !== '' ? 'cari' : 'kode') }">
        <div class="flex gap-1 mb-3 border-b border-slate-200">
            <button type="button" @click="mode = 'kode'"
                    class="px-4 py-2.5 text-sm font-semibold transition"
                    :class="mode === 'kode' ? 'text-brand-blue border-b-2 border-brand-blue' : 'text-slate-500 hover:text-brand-blue border-b-2 border-transparent'">
                Nomor Pengaduan
            </button>
            <button type="button" @click="mode = 'cari'"
                    class="px-4 py-2.5 text-sm font-semibold transition"
                    :class="mode === 'cari' ? 'text-brand-blue border-b-2 border-brand-blue' : 'text-slate-500 hover:text-brand-blue border-b-2 border-transparent'">
                Nama / No HP / NPA
            </button>
        </div>

        <form method="GET" action="/lacak" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row gap-3">
            <template x-if="mode === 'kode'">
                <input type="text" name="kode" value="{{ $kodeDicari }}" placeholder="Contoh: PGD-20260818-00001"
                       class="flex-1 h-12 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition uppercase placeholder:normal-case">
            </template>
            <template x-if="mode === 'cari'">
                <input type="text" name="cari" value="{{ $cariDicari }}" placeholder="Contoh: Imanuel Hulu / 0812xxxxxxx / NPA1234"
                       class="flex-1 h-12 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
            </template>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-brand-blue text-white font-semibold rounded-xl px-6 py-3 shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition text-sm">
                🔍 Lacak
            </button>
        </form>
    </div>

    {{-- ===== STATE: BELUM MENCARI APAPUN ===== --}}
    @if (!$sudahDicari)
        <div class="text-center py-16 sm:py-20">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-brand-blue/10 flex items-center justify-center mx-auto mb-5">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#0B6FB4" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <p class="font-display font-semibold text-ink">Masukkan nomor pengaduan, nama, no HP, atau NPA Anda</p>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                Nomor pengaduan bisa Anda temukan di halaman sukses setelah mengirim
                laporan, atau di surat pengaduan yang sudah dicetak. Belum ingat nomornya?
                Cari saja pakai nama, no HP, atau NPA yang dipakai saat melapor.
            </p>
        </div>

    {{-- ===== STATE: DICARI PAKAI NOMOR PENGADUAN, TAPI TIDAK KETEMU ===== --}}
    @elseif ($kodeDicari !== '' && !$pengaduan)
        <div class="text-center py-16 sm:py-20">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-5">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            </div>
            <p class="font-display font-semibold text-ink">Pengaduan tidak ditemukan</p>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                Nomor pengaduan <span class="font-semibold text-ink">{{ $kodeDicari }}</span> tidak
                terdaftar di sistem kami. Periksa kembali penulisannya, pastikan
                formatnya seperti <span class="font-mono">PGD-20260818-00001</span>.
            </p>
        </div>

    {{-- ===== STATE: DICARI PAKAI NAMA/NO HP/NPA -- DAFTAR HASIL ===== --}}
    @elseif ($cariDicari !== '')
        @if ($hasilPencarian->isEmpty())
            <div class="text-center py-16 sm:py-20">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-5">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                </div>
                <p class="font-display font-semibold text-ink">Tidak ada pengaduan yang ditemukan</p>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                    Tidak ada pengaduan dengan nama, no HP, atau NPA
                    <span class="font-semibold text-ink">{{ $cariDicari }}</span>.
                    Pastikan penulisannya sama seperti saat Anda melapor.
                </p>
            </div>
        @else
            <div class="mt-8">
                <p class="text-sm text-slate-500 mb-4">
                    Ditemukan <span class="font-semibold text-ink">{{ $hasilPencarian->count() }}</span>
                    pengaduan untuk "<span class="font-semibold text-ink">{{ $cariDicari }}</span>". Pilih salah satu untuk lihat detail & riwayat progresnya.
                </p>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden divide-y divide-slate-50">
                    @foreach ($hasilPencarian as $item)
                        <a href="/lacak?kode={{ $item->kode_pengaduan }}&dari_cari={{ urlencode($cariDicari) }}" class="flex items-center justify-between gap-3 px-5 py-4 hover:bg-slate-50 transition">
                            <div class="min-w-0">
                                <p class="font-display font-semibold text-brand-blue text-sm tracking-wide">{{ $item->kode_pengaduan }}</p>
                                <p class="text-sm text-ink font-medium mt-0.5 truncate">{{ $item->judul }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }} &middot; {{ $item->created_at->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->statusColor() }}">
                                    {{ $item->statusLabel() }}
                                </span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-300"><path d="M9 18l6-6-6-6"/></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    {{-- ===== STATE: KETEMU (via nomor pengaduan) ===== --}}
    @else
        <div class="mt-8 space-y-6" x-data="{ lightboxUrl: null, tolakOpen: false, confirmSetuju: false }">

            {{-- Ringkasan pengaduan --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-7">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">Nomor Pengaduan</p>
                        <p class="font-display font-bold text-lg sm:text-xl text-brand-blue tracking-wide">{{ $pengaduan->kode_pengaduan }}</p>
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
                        <p class="text-xs text-slate-400">Tanggal Dibuat</p>
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
                    @if ($pengaduan->petugas)
                        <div>
                            <p class="text-xs text-slate-400">Ditangani Oleh</p>
                            <p class="text-ink font-medium mt-0.5">{{ $pengaduan->petugas->name }}</p>
                        </div>
                    @endif
                </div>

                {{-- Foto bukti dari pelapor --}}
                @if ($pengaduan->fotos->count() > 0)
                    <div class="mt-5 pt-5 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-2">Foto Bukti dari Pelapor</p>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach ($pengaduan->fotos as $foto)
                                <img src="{{ $foto->url() }}" @click="lightboxUrl = '{{ $foto->url() }}'"
                                     class="w-full h-16 sm:h-20 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition cursor-zoom-in">
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat" class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal border border-brand-teal/30 rounded-full px-5 py-2.5 hover:bg-brand-teal/5 transition">
                    🖨️ Lihat / Cetak Surat Pengaduan
                </a>
            </div>

            {{-- Kartu Surat Pemberitahuan per tahap status --}}
            @if (count($pengaduan->daftarSuratStatusTersedia()) > 0)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-7">
                    <p class="font-display font-semibold text-ink mb-1">📋 Surat Pemberitahuan</p>
                    <p class="text-xs text-slate-400 mb-4">Surat resmi yang diterbitkan di setiap tahap penanganan pengaduan Anda.</p>
                    <div class="grid sm:grid-cols-2 gap-2">
                        @foreach ($pengaduan->daftarSuratStatusTersedia() as $jenisSurat => $namaSurat)
                            <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat/{{ $jenisSurat }}" target="_blank" rel="noopener"
                               class="flex items-center gap-2.5 bg-slate-50 hover:bg-slate-100 transition rounded-xl p-3 border border-slate-200">
                                <span class="text-xl">📄</span>
                                <span class="text-sm text-ink font-medium flex-1">{{ $namaSurat }}</span>
                                <span class="text-xs text-brand-blue font-semibold shrink-0">Buka ↗</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Kartu Persetujuan Biaya --}}
            @if ($pengaduan->butuhPersetujuan())
                <div class="bg-amber-50 rounded-2xl border border-amber-200 shadow-sm p-5 sm:p-7">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl">⚠️</span>
                        <p class="font-display font-semibold text-ink">Menunggu Persetujuan Anda</p>
                    </div>

                    @if ($pengaduan->catatan_verifikasi_pembayaran)
                        <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-4">
                            <p class="text-xs font-semibold text-red-600 mb-1">⚠️ Bukti pembayaran sebelumnya ditolak</p>
                            <p class="text-xs text-red-500 leading-relaxed">{{ $pengaduan->catatan_verifikasi_pembayaran }}</p>
                            <p class="text-xs text-red-500 mt-1">Mohon upload ulang bukti pembayaran yang benar di bawah ini.</p>
                        </div>
                    @else
                        <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                            Setelah dicek petugas, penanganan pengaduan ini memerlukan biaya. Silakan lihat rincian
                            biayanya di bawah, lalu pilih <span class="font-semibold text-ink">Setuju</span> (upload
                            bukti bayar) untuk melanjutkan, atau <span class="font-semibold text-ink">Tidak Setuju</span> untuk
                            membatalkan pengaduan.
                        </p>
                    @endif

                    <div class="bg-white rounded-xl border border-amber-200 p-4 mb-4">
                        <p class="text-xs text-slate-400 mb-2">Rincian Biaya</p>
                        @if ($pengaduan->rincianBiayaFileUrl())
                            <a href="{{ $pengaduan->rincianBiayaFileUrl() }}" target="_blank" rel="noopener"
                               class="flex items-center gap-3 bg-slate-50 hover:bg-slate-100 transition rounded-lg p-3 mb-3">
                                <span class="text-2xl">{{ $pengaduan->rincianBiayaFileIcon() }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-ink font-medium truncate">{{ $pengaduan->rincian_biaya_file_nama_asli ?? 'Dokumen Rincian Biaya' }}</p>
                                    <p class="text-xs text-slate-400">Klik untuk lihat / unduh</p>
                                </div>
                                <span class="text-brand-blue text-xs font-semibold shrink-0">Buka ↗</span>
                            </a>
                        @endif
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Total Biaya</span>
                            <span class="font-display font-bold text-lg text-amber-600">{{ $pengaduan->formattedTotalBiaya() }}</span>
                        </div>
                    </div>

                    @if (!$errors->has('catatan_persetujuan'))
                        <div x-show="!tolakOpen">
                            {{-- Setuju + wajib upload bukti pembayaran --}}
                            <form method="POST" action="/pengaduan/{{ $pengaduan->kode_pengaduan }}/setuju" enctype="multipart/form-data" x-ref="formSetuju">
                                @csrf
                                <label class="block text-sm font-medium text-ink mb-1.5">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                                <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                                       class="w-full text-sm rounded-xl border {{ $errors->has('bukti_pembayaran') ? 'border-red-400' : 'border-slate-200' }} px-3 py-2.5 bg-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-brand-blue/10 file:text-brand-blue file:text-xs file:font-semibold">
                                @error('bukti_pembayaran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                <p class="text-xs text-slate-400 mt-1.5 mb-3">Format JPG, PNG, atau PDF. Maksimal 5MB.</p>

                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button type="button" @click="$refs.formSetuju.reportValidity() && (confirmSetuju = true)"
                                            class="flex-1 h-11 rounded-xl bg-brand-green text-white font-semibold text-sm shadow-lg shadow-brand-green/30 hover:opacity-90 transition">
                                        ✓ Setuju & Kirim Bukti Bayar
                                    </button>
                                    <button type="button" @click="tolakOpen = true" class="flex-1 h-11 rounded-xl border border-red-300 text-red-600 font-semibold text-sm hover:bg-red-50 transition">
                                        ✕ Tidak Setuju
                                    </button>
                                </div>

                                {{-- Modal konfirmasi — sengaja ditaruh DI DALAM form yang sama (bukan di-teleport), --}}
                                {{-- supaya tombol "Ya, Kirim" bisa jadi tombol submit asli tanpa perlu $refs lintas elemen. --}}
                                <div x-show="confirmSetuju" @keydown.escape.window="confirmSetuju = false" x-cloak
                                     x-transition class="fixed inset-0 z-[100] bg-black/50 flex items-center justify-center p-4" style="display:none">
                                    <div class="absolute inset-0" @click="confirmSetuju = false"></div>
                                    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                                        <div class="w-11 h-11 rounded-full bg-brand-green/10 flex items-center justify-center mb-3">
                                            <span class="text-xl">✓</span>
                                        </div>
                                        <p class="font-display font-bold text-lg text-ink mb-1.5">Konfirmasi Persetujuan</p>
                                        <p class="text-sm text-slate-500 mb-5 leading-relaxed">
                                            Anda akan menyetujui biaya sebesar
                                            <span class="font-semibold text-ink">{{ $pengaduan->formattedTotalBiaya() }}</span>
                                            dan mengirim bukti pembayaran yang sudah dipilih. Pastikan filenya sudah benar.
                                        </p>
                                        <div class="flex gap-2">
                                            <button type="button" @click="confirmSetuju = false" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                                            <button type="submit" class="flex-1 h-11 rounded-xl bg-brand-green text-white text-sm font-semibold hover:opacity-90 transition">Ya, Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Form alasan penolakan --}}
                    <div x-show="tolakOpen || {{ $errors->has('catatan_persetujuan') ? 'true' : 'false' }}" style="display:none" x-cloak>
                        <form method="POST" action="/pengaduan/{{ $pengaduan->kode_pengaduan }}/tolak-biaya" class="mt-2">
                            @csrf
                            <label class="block text-sm font-medium text-ink mb-1.5">Alasan tidak setuju <span class="text-slate-400 font-normal text-xs">— opsional</span></label>
                            <textarea name="catatan_persetujuan" rows="3" placeholder="Contoh: Biayanya terlalu mahal, saya mau tunda dulu."
                                      class="w-full rounded-xl border {{ $errors->has('catatan_persetujuan') ? 'border-red-400' : 'border-slate-200' }} px-4 py-3 text-sm resize-none mb-1 focus:ring-2 focus:ring-red-300 outline-none">{{ old('catatan_persetujuan') }}</textarea>
                            @error('catatan_persetujuan')<p class="text-red-500 text-xs mb-3">{{ $message }}</p>@enderror
                            <div class="flex gap-2 mt-3">
                                <button type="button" @click="tolakOpen = false" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                                <button type="submit" class="flex-1 h-11 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                                    Ya, Batalkan Pengaduan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @elseif ($pengaduan->menungguVerifikasiPembayaran())
                {{-- Sudah setuju & upload bukti bayar, tinggal nunggu admin cek --}}
                <div class="bg-cyan-50 rounded-2xl border border-cyan-200 shadow-sm p-5 sm:p-7">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl">⏳</span>
                        <p class="font-display font-semibold text-ink">Bukti Pembayaran Sedang Diverifikasi</p>
                    </div>
                    <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                        Terima kasih, bukti pembayaran Anda sudah kami terima dan sedang dicek oleh admin.
                        Halaman ini akan otomatis update statusnya begitu sudah diverifikasi.
                    </p>
                    <div class="bg-white rounded-xl border border-cyan-200 p-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400">Total Biaya Disetujui</p>
                            <span class="font-display font-bold text-lg text-cyan-700">{{ $pengaduan->formattedTotalBiaya() }}</span>
                        </div>
                        @if ($pengaduan->buktiPembayaranUrl())
                            <a href="{{ $pengaduan->buktiPembayaranUrl() }}" target="_blank" rel="noopener" class="text-xs font-semibold text-brand-blue">Lihat Bukti Bayar ↗</a>
                        @endif
                    </div>
                </div>

            @elseif (!is_null($pengaduan->total_biaya))
                {{-- total_biaya sudah pernah diisi admin: bisa gratis (0), atau ada biaya yang sudah disetujui/ditolak --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-7">
                    <p class="font-display font-semibold text-ink mb-3">Biaya Penanganan</p>
                    <div class="bg-slate-50 rounded-xl p-4 text-sm">
                        @if ($pengaduan->rincianBiayaFileUrl())
                            <a href="{{ $pengaduan->rincianBiayaFileUrl() }}" target="_blank" rel="noopener"
                               class="flex items-center gap-3 bg-white hover:bg-slate-100 transition rounded-lg p-3 mb-3 border border-slate-200">
                                <span class="text-2xl">{{ $pengaduan->rincianBiayaFileIcon() }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-ink font-medium truncate">{{ $pengaduan->rincian_biaya_file_nama_asli ?? 'Dokumen Rincian Biaya' }}</p>
                                    <p class="text-xs text-slate-400">Klik untuk lihat / unduh</p>
                                </div>
                            </a>
                        @endif
                        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Total Biaya</span>
                            @if ((float) $pengaduan->total_biaya <= 0)
                                <span class="font-display font-bold text-brand-green">Gratis</span>
                            @else
                                <span class="font-display font-bold text-ink">{{ $pengaduan->formattedTotalBiaya() }}</span>
                            @endif
                        </div>

                        @if ((float) $pengaduan->total_biaya <= 0)
                            <p class="text-xs mt-2 text-brand-green">✓ Pengaduan ini tidak dikenakan biaya</p>
                        @elseif ($pengaduan->status_persetujuan === 'disetujui')
                            <p class="text-xs mt-2 text-brand-green">
                                ✓ Sudah disetujui & dibayar pelanggan
                                @if ($pengaduan->tanggal_persetujuan)
                                    pada {{ $pengaduan->tanggal_persetujuan->translatedFormat('d F Y, H:i') }} WIB
                                @endif
                            </p>
                        @elseif ($pengaduan->status_persetujuan === 'ditolak')
                            <p class="text-xs mt-2 text-red-500">
                                ✕ Ditolak pelanggan
                                @if ($pengaduan->tanggal_persetujuan)
                                    pada {{ $pengaduan->tanggal_persetujuan->translatedFormat('d F Y, H:i') }} WIB
                                @endif
                            </p>
                        @endif

                        @if ($pengaduan->buktiPembayaranUrl())
                            <a href="{{ $pengaduan->buktiPembayaranUrl() }}" target="_blank" rel="noopener" class="inline-block text-xs font-semibold text-brand-blue mt-2">Lihat Bukti Bayar ↗</a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Timeline --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-7">
                <p class="font-display font-semibold text-ink mb-6">Riwayat Perkembangan</p>

                <div class="space-y-0">
                    @foreach ($pengaduan->tanggapans as $tanggapan)
                        <div class="flex gap-4">
                            {{-- Titik & garis penghubung --}}
                            <div class="flex flex-col items-center">
                                <span class="w-3.5 h-3.5 rounded-full {{ $tanggapan->dotColorClass() }} ring-4 ring-white shrink-0 mt-1"></span>
                                @if (!$loop->last)
                                    <span class="w-0.5 flex-1 bg-slate-100 my-1"></span>
                                @endif
                            </div>

                            {{-- Konten --}}
                            <div class="pb-6 {{ $loop->last ? '' : '' }} flex-1">
                                <p class="text-xs text-slate-400">{{ $tanggapan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                <p class="text-sm text-ink mt-1 leading-relaxed">{{ $tanggapan->pesan }}</p>

                                @if ($tanggapan->user)
                                    <p class="text-xs text-slate-400 mt-1">oleh {{ $tanggapan->user->name }}</p>
                                @endif

                                @if ($tanggapan->jenis_surat && $pengaduan->suratTersedia($tanggapan->jenis_surat))
                                    <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat/{{ $tanggapan->jenis_surat }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-blue mt-1.5">
                                        📄 Lihat {{ $pengaduan->namaSurat($tanggapan->jenis_surat) }} ↗
                                    </a>
                                @endif

                                @if ($tanggapan->fotos->count() > 0)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach ($tanggapan->fotos as $foto)
                                            <img src="{{ $foto->url() }}" @click="lightboxUrl = '{{ $foto->url() }}'"
                                                 class="h-20 w-20 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition cursor-zoom-in">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                @if (request()->query('dari_cari'))
                    <a href="/lacak?cari={{ urlencode(request()->query('dari_cari')) }}" class="text-sm font-semibold text-slate-500 hover:text-brand-blue transition">
                        ← Kembali ke hasil pencarian
                    </a>
                @else
                    <a href="/lacak" class="text-sm font-semibold text-slate-500 hover:text-brand-blue transition">
                        ← Lacak pengaduan lain
                    </a>
                @endif
            </div>

            {{-- Lightbox: klik foto untuk lihat ukuran penuh --}}
            {{-- x-teleport = dipindahkan langsung ke akhir <body> saat dijalankan, --}}
            {{-- supaya dijamin nutup dari ujung ke ujung layar, gak kepengaruh navbar/elemen lain. --}}
            <template x-teleport="body">
                <div x-show="lightboxUrl" @click="lightboxUrl = null" @keydown.escape.window="lightboxUrl = null"
                     x-transition class="fixed inset-0 z-[100] bg-black/90 flex items-center justify-center p-4 sm:p-8 cursor-zoom-out overflow-y-auto" style="display:none">
                    <button type="button" @click="lightboxUrl = null"
                            class="fixed top-3 right-3 sm:top-6 sm:right-6 z-[110] w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/15 hover:bg-white/25 text-white flex items-center justify-center text-xl backdrop-blur-sm transition">
                        ✕
                    </button>
                    <img :src="lightboxUrl" @click.stop class="max-w-full max-h-full object-contain rounded-xl shadow-2xl my-auto">
                </div>
            </template>
        </div>
    @endif

</section>
@endsection