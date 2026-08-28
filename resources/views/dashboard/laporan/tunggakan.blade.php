@extends('layouts.dashboard')

@section('title', 'Laporan Tunggakan')

@section('content')

    <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
        <div>
            <p class="font-display font-semibold text-lg text-ink">Laporan Tunggakan</p>
            <p class="text-sm text-slate-500">Pengaduan berbiaya yang belum lunas — belum direspon pelanggan atau belum diverifikasi admin.</p>
        </div>
        <div class="flex gap-2">
            <a href="/dashboard/laporan/tunggakan/export-pdf?{{ http_build_query(request()->query()) }}" target="_blank"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                🖨️ Export PDF
            </a>
            <a href="/dashboard/laporan/tunggakan/export-csv?{{ http_build_query(request()->query()) }}"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                📊 Export CSV (Excel)
            </a>
        </div>
    </div>

    {{-- Tab navigasi antar jenis laporan --}}
    <div class="flex gap-1 mb-5 border-b border-slate-200">
        <a href="/dashboard/laporan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Pengaduan</a>
        <a href="/dashboard/laporan/keuangan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Keuangan</a>
        <span class="px-4 py-2.5 text-sm font-semibold text-brand-blue border-b-2 border-brand-blue">Tunggakan</span>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5 text-xs text-amber-700">
        ℹ️ Laporan ini nunjukin kondisi <strong>saat ini</strong> (bukan periode tertentu) — jadi gak ada filter tanggal, cuma filter kategori.
    </div>

    {{-- Filter --}}
    <form method="GET" action="/dashboard/laporan/tunggakan" class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 mb-6">
        <div class="grid sm:grid-cols-2 gap-3">
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <label class="block text-xs font-medium text-slate-500 mb-1">Kategori</label>
                <button type="button" @click="open = !open"
                        class="w-full h-10 rounded-lg border border-slate-200 px-3 text-sm bg-white text-left flex items-center justify-between">
                    <span class="truncate">{{ count($kategoriIds) > 0 ? count($kategoriIds) . ' kategori dipilih' : 'Semua Kategori' }}</span>
                    <span class="text-slate-400 shrink-0">▾</span>
                </button>
                <div x-show="open" x-cloak x-transition class="absolute z-20 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg max-h-56 overflow-y-auto p-2" style="display:none">
                    @forelse ($kategoriList as $k)
                        <label class="flex items-center gap-2 px-2 py-1.5 rounded hover:bg-slate-50 text-sm cursor-pointer">
                            <input type="checkbox" name="kategori_id[]" value="{{ $k->id }}" {{ in_array($k->id, $kategoriIds) ? 'checked' : '' }} class="accent-brand-blue">
                            {{ $k->nama }}
                        </label>
                    @empty
                        <p class="text-xs text-slate-400 px-2 py-1.5">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full h-10 rounded-lg bg-brand-blue text-white text-sm font-semibold hover:bg-brand-bluelight transition">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>

    {{-- KPI cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Total Tunggakan</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-amber-600 mt-1">{{ \App\Models\Pengaduan::formatRupiah($totalTunggakan) }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $jumlahTunggakan }} pengaduan</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Menunggu Persetujuan Pelanggan</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-ink mt-1">{{ $jumlahMenungguPersetujuan }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ \App\Models\Pengaduan::formatRupiah($totalMenungguPersetujuan) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Menunggu Verifikasi Admin</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-cyan-600 mt-1">{{ $jumlahMenungguVerifikasi }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ \App\Models\Pengaduan::formatRupiah($totalMenungguVerifikasi) }}</p>
        </div>
    </div>

    {{-- Tabel detail --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <p class="font-display font-semibold text-ink">Daftar Tunggakan ({{ $jumlahTunggakan }})</p>
        </div>
        <div class="divide-y divide-slate-50 max-h-[600px] overflow-y-auto">
            @forelse ($daftar as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink truncate">{{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->kode_pengaduan }}
                            @if ($item->tanggal_pemeriksaan)
                                &middot; sudah menunggu {{ \App\Models\Pengaduan::formatLamaMenunggu($item->tanggal_pemeriksaan) }}
                            @endif
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-display font-bold text-amber-600">{{ $item->formattedTotalBiaya() }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $item->statusColor() }}">
                            {{ $item->statusLabel() }}
                        </span>
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-400 px-5 py-8 text-center">🎉 Tidak ada tunggakan saat ini.</p>
            @endforelse
        </div>
    </div>

@endsection
