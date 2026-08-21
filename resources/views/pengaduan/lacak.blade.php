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
            Masukkan nomor pengaduan yang Anda terima saat mengirim laporan
            untuk melihat perkembangan penanganannya.
        </p>
    </div>

    {{-- Form pencarian --}}
    <form method="GET" action="/lacak" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row gap-3">
        <input type="text" name="kode" value="{{ $kodeDicari }}" placeholder="Contoh: PGD-20260818-00001"
               class="flex-1 h-12 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition uppercase placeholder:normal-case">
        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-brand-blue text-white font-semibold rounded-xl px-6 py-3 shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition text-sm">
            🔍 Lacak
        </button>
    </form>

    {{-- ===== STATE: BELUM MENCARI APAPUN ===== --}}
    @if (!$sudahDicari)
        <div class="text-center py-16 sm:py-20">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-brand-blue/10 flex items-center justify-center mx-auto mb-5">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#0B6FB4" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <p class="font-display font-semibold text-ink">Masukkan nomor pengaduan Anda</p>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                Nomor pengaduan bisa Anda temukan di halaman sukses setelah mengirim
                laporan, atau di surat pengaduan yang sudah dicetak.
            </p>
        </div>

    {{-- ===== STATE: DICARI TAPI TIDAK KETEMU ===== --}}
    @elseif (!$pengaduan)
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

    {{-- ===== STATE: KETEMU ===== --}}
    @else
        <div class="mt-8 space-y-6">

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
                                <a href="{{ $foto->url() }}" target="_blank" class="block">
                                    <img src="{{ $foto->url() }}" class="w-full h-16 sm:h-20 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat" class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal border border-brand-teal/30 rounded-full px-5 py-2.5 hover:bg-brand-teal/5 transition">
                    🖨️ Lihat / Cetak Surat Pengaduan
                </a>
            </div>

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

            <div class="text-center">
                <a href="/lacak" class="text-sm font-semibold text-slate-500 hover:text-brand-blue transition">
                    ← Lacak pengaduan lain
                </a>
            </div>
        </div>
    @endif

</section>
@endsection
