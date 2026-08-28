@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')

@section('content')

    <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
        <div>
            <p class="font-display font-semibold text-lg text-ink">Laporan Keuangan</p>
            <p class="text-sm text-slate-500">Rekap pemasukan dari biaya penanganan pengaduan yang sudah dibayar & diverifikasi.</p>
        </div>
        <div class="flex gap-2">
            <a href="/dashboard/laporan/keuangan/export-pdf?{{ http_build_query(request()->query()) }}" target="_blank"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                🖨️ Export PDF
            </a>
            <a href="/dashboard/laporan/keuangan/export-csv?{{ http_build_query(request()->query()) }}"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                📊 Export CSV (Excel)
            </a>
        </div>
    </div>

    {{-- Tab navigasi antar jenis laporan --}}
    <div class="flex gap-1 mb-5 border-b border-slate-200">
        <a href="/dashboard/laporan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Pengaduan</a>
        <span class="px-4 py-2.5 text-sm font-semibold text-brand-blue border-b-2 border-brand-blue">Keuangan</span>
        <a href="/dashboard/laporan/tunggakan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Tunggakan</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="/dashboard/laporan/keuangan" class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 mb-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal Bayar</label>
                <input type="date" name="dari" value="{{ $dari->toDateString() }}"
                       class="w-full h-10 rounded-lg border border-slate-200 px-3 text-sm focus:ring-2 focus:ring-brand-blue outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal Bayar</label>
                <input type="date" name="sampai" value="{{ $sampai->toDateString() }}"
                       class="w-full h-10 rounded-lg border border-slate-200 px-3 text-sm focus:ring-2 focus:ring-brand-blue outline-none">
            </div>
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
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Total Pemasukan</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-brand-green mt-1">{{ \App\Models\Pengaduan::formatRupiah($totalPemasukan) }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $dari->translatedFormat('d M Y') }} – {{ $sampai->translatedFormat('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Jumlah Transaksi</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-ink mt-1">{{ $jumlahTransaksi }}</p>
            <p class="text-[11px] text-slate-400 mt-1">pengaduan berbayar</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Rata-rata / Transaksi</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-brand-teal mt-1">{{ \App\Models\Pengaduan::formatRupiah($rataRataTransaksi) }}</p>
            <p class="text-[11px] text-slate-400 mt-1">per pengaduan berbayar</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Kategori Penyumbang Terbesar</p>
            <p class="font-display font-bold text-base sm:text-lg text-ink mt-1 line-clamp-2">{{ $kategoriTerbesar ?? '-' }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $perKategori->first() !== null ? \App\Models\Pengaduan::formatRupiah($perKategori->first()) : '' }}</p>
        </div>
        <div class="bg-red-50 rounded-2xl border border-red-100 p-5">
            <p class="text-xs text-red-400">Potensi Hilang (Ditolak)</p>
            <p class="font-display font-bold text-xl sm:text-2xl text-red-500 mt-1">{{ \App\Models\Pengaduan::formatRupiah($totalPendapatanHilang) }}</p>
            <p class="text-[11px] text-red-400 mt-1">{{ $jumlahDitolak }} pengaduan dibatalkan</p>
        </div>
    </div>

    {{-- Pengaduan berbayar yang ditolak/dibatalkan pelanggan --}}
    @if ($jumlahDitolak > 0)
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6">
            <div class="px-5 py-4 border-b border-slate-100">
                <p class="font-display font-semibold text-ink">Pengaduan Dibatalkan Pelanggan ({{ $jumlahDitolak }})</p>
                <p class="text-xs text-slate-400 mt-0.5">Biaya sudah diajukan tapi ditolak/dibatalkan pelanggan sebelum dibayar — dihitung sebagai potensi pendapatan yang hilang, bukan pemasukan.</p>
            </div>
            <div class="divide-y divide-slate-50 max-h-[360px] overflow-y-auto">
                @foreach ($ditolak as $item)
                    <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink truncate">{{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $item->kode_pengaduan }} &middot; dibatalkan {{ $item->tanggal_ditolak?->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                        <span class="shrink-0 font-display font-bold text-red-500">{{ $item->formattedTotalBiaya() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Grafik tren pemasukan --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-6">
        <p class="font-display font-semibold text-ink mb-4">Tren Pemasukan ({{ $perBulan ? 'per Bulan' : 'per Hari' }})</p>
        @if (count($trenLabel) > 0)
            <canvas id="chartTren" height="80"></canvas>
        @else
            <p class="text-sm text-slate-400 text-center py-10">Tidak ada transaksi pada periode ini.</p>
        @endif
    </div>

    {{-- Breakdown per kategori --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-6">
        <p class="font-display font-semibold text-ink mb-4">Pemasukan per Kategori</p>
        @forelse ($perKategori as $nama => $nominal)
            <div class="flex items-center justify-between text-sm py-1.5 border-b border-slate-50 last:border-0">
                <span class="text-slate-600">{{ $nama }}</span>
                <div class="text-right">
                    <span class="font-semibold text-ink">{{ \App\Models\Pengaduan::formatRupiah($nominal) }}</span>
                    <span class="text-xs text-slate-400 ml-1.5">({{ $totalPemasukan > 0 ? round($nominal / $totalPemasukan * 100, 1) : 0 }}%)</span>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400 text-center py-6">Tidak ada data pada periode ini.</p>
        @endforelse
    </div>

    {{-- Tabel detail transaksi --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <p class="font-display font-semibold text-ink">Detail Transaksi ({{ $jumlahTransaksi }})</p>
        </div>
        <div class="divide-y divide-slate-50 max-h-[500px] overflow-y-auto">
            @forelse ($transaksi as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink truncate">{{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->kode_pengaduan }} &middot; dibayar {{ $item->tanggal_persetujuan?->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="shrink-0 font-display font-bold text-brand-green">{{ $item->formattedTotalBiaya() }}</span>
                </a>
            @empty
                <p class="text-sm text-slate-400 px-5 py-8 text-center">Tidak ada transaksi pada periode/filter ini.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        if (typeof Chart === 'undefined') {
            const el = document.getElementById('chartTren');
            if (el) {
                const pesan = document.createElement('p');
                pesan.className = 'text-sm text-red-500 text-center py-10';
                pesan.textContent = 'Grafik gagal dimuat (koneksi ke CDN Chart.js bermasalah). Data angkanya tetap valid, lihat daftar di bawah.';
                el.replaceWith(pesan);
            }
        } else {
        @if (count($trenLabel) > 0)
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($trenLabel),
                datasets: [{
                    label: 'Pemasukan (Rp)',
                    data: @json($trenData),
                    borderColor: '#3FA75B',
                    backgroundColor: 'rgba(63,167,91,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (ctx) => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID') } }
                },
                scales: { y: { beginAtZero: true, ticks: { callback: (v) => 'Rp ' + v.toLocaleString('id-ID') } } }
            }
        });
        @endif
        }
    </script>

@endsection
