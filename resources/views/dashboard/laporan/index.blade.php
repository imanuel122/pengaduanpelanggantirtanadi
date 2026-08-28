@extends('layouts.dashboard')

@section('title', 'Laporan')

@section('content')

    <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
        <div>
            <p class="font-display font-semibold text-lg text-ink">Laporan Pengaduan</p>
            <p class="text-sm text-slate-500">Ringkasan & statistik pengaduan berdasarkan periode yang dipilih.</p>
        </div>
        <div class="flex gap-2">
            <a href="/dashboard/laporan/export-pdf?{{ http_build_query(request()->query()) }}" target="_blank"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                🖨️ Export PDF
            </a>
            <a href="/dashboard/laporan/export-csv?{{ http_build_query(request()->query()) }}"
               class="h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 hover:text-brand-blue transition inline-flex items-center gap-2">
                📊 Export CSV (Excel)
            </a>
        </div>
    </div>

    {{-- Tab navigasi antar jenis laporan --}}
    <div class="flex gap-1 mb-5 border-b border-slate-200">
        <span class="px-4 py-2.5 text-sm font-semibold text-brand-blue border-b-2 border-brand-blue">Pengaduan</span>
        <a href="/dashboard/laporan/keuangan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Keuangan</a>
        <a href="/dashboard/laporan/tunggakan" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-brand-blue transition">Tunggakan</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="/dashboard/laporan" class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 mb-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $dari->toDateString() }}"
                       class="w-full h-10 rounded-lg border border-slate-200 px-3 text-sm focus:ring-2 focus:ring-brand-blue outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
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
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                <button type="button" @click="open = !open"
                        class="w-full h-10 rounded-lg border border-slate-200 px-3 text-sm bg-white text-left flex items-center justify-between">
                    <span class="truncate">{{ count($statusFilterList) > 0 ? count($statusFilterList) . ' status dipilih' : 'Semua Status' }}</span>
                    <span class="text-slate-400 shrink-0">▾</span>
                </button>
                <div x-show="open" x-cloak x-transition class="absolute z-20 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg max-h-56 overflow-y-auto p-2" style="display:none">
                    @foreach ($labelStatus as $key => $label)
                        <label class="flex items-center gap-2 px-2 py-1.5 rounded hover:bg-slate-50 text-sm cursor-pointer">
                            <input type="checkbox" name="status[]" value="{{ $key }}" {{ in_array($key, $statusFilterList) ? 'checked' : '' }} class="accent-brand-blue">
                            {{ $label }}
                        </label>
                    @endforeach
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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Total Pengaduan</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-ink mt-1">{{ $totalPengaduan }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $dari->translatedFormat('d M Y') }} – {{ $sampai->translatedFormat('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Selesai</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-brand-green mt-1">{{ $totalSelesai }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $totalPengaduan > 0 ? round($totalSelesai / $totalPengaduan * 100) : 0 }}% dari total</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Ditolak</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-red-500 mt-1">{{ $totalDitolak }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $totalPengaduan > 0 ? round($totalDitolak / $totalPengaduan * 100) : 0 }}% dari total</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="text-xs text-slate-400">Rata-rata Waktu Selesai</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-brand-teal mt-1">
                {{ $rataRataHariSelesai !== null ? $rataRataHariSelesai . ' hari' : '-' }}
            </p>
            <p class="text-[11px] text-slate-400 mt-1">dari {{ $totalSelesai }} pengaduan selesai</p>
        </div>
    </div>

    {{-- Grafik tren --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-6">
        <p class="font-display font-semibold text-ink mb-4">Tren Pengaduan Masuk ({{ $perBulan ? 'per Bulan' : 'per Hari' }})</p>
        @if (count($trenLabel) > 0)
            <canvas id="chartTren" height="80"></canvas>
        @else
            <p class="text-sm text-slate-400 text-center py-10">Tidak ada data pada periode ini.</p>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-6">
        {{-- Grafik per kategori --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="font-display font-semibold text-ink mb-4">Pengaduan per Kategori</p>
            @if ($perKategori->count() > 0)
                <canvas id="chartKategori" height="220"></canvas>
                <div class="mt-4 space-y-1.5">
                    @foreach ($perKategori as $nama => $jumlah)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">{{ $nama }}</span>
                            <span class="font-semibold text-ink">{{ $jumlah }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-400 text-center py-10">Tidak ada data pada periode ini.</p>
            @endif
        </div>

        {{-- Grafik per status --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <p class="font-display font-semibold text-ink mb-4">Pengaduan per Status</p>
            @if ($perStatus->count() > 0)
                <canvas id="chartStatus" height="220"></canvas>
                <div class="mt-4 space-y-1.5">
                    @foreach ($perStatus as $nama => $jumlah)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">{{ $nama }}</span>
                            <span class="font-semibold text-ink">{{ $jumlah }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-400 text-center py-10">Tidak ada data pada periode ini.</p>
            @endif
        </div>
    </div>

    {{-- Tabel detail --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <p class="font-display font-semibold text-ink">Detail Pengaduan ({{ $totalPengaduan }})</p>
        </div>
        <div class="divide-y divide-slate-50 max-h-[500px] overflow-y-auto">
            @forelse ($daftarPengaduan as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->kode_pengaduan }} &middot; {{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }} &middot; {{ $item->created_at->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                </a>
            @empty
                <p class="text-sm text-slate-400 px-5 py-8 text-center">Tidak ada pengaduan pada periode/filter ini.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const warnaPalet = ['#0B6FB4', '#14958C', '#3FA75B', '#8CC63F', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'];

        if (typeof Chart === 'undefined') {
            // CDN gagal dimuat (mati / diblokir jaringan) -- kasih tahu jelas, jangan diam-diam gagal.
            document.querySelectorAll('#chartTren, #chartKategori, #chartStatus').forEach((el) => {
                const pesan = document.createElement('p');
                pesan.className = 'text-sm text-red-500 text-center py-10';
                pesan.textContent = 'Grafik gagal dimuat (koneksi ke CDN Chart.js bermasalah). Data angkanya tetap valid, lihat daftar di bawah.';
                el.replaceWith(pesan);
            });
        } else {

        @if (count($trenLabel) > 0)
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($trenLabel),
                datasets: [{
                    label: 'Pengaduan Masuk',
                    data: @json($trenData),
                    borderColor: '#0B6FB4',
                    backgroundColor: 'rgba(11,111,180,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        @endif

        @if ($perKategori->count() > 0)
        new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: @json($perKategori->keys()),
                datasets: [{
                    data: @json($perKategori->values()),
                    backgroundColor: warnaPalet,
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        @endif

        @if ($perStatus->count() > 0)
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: @json($perStatus->keys()),
                datasets: [{
                    data: @json($perStatus->values()),
                    backgroundColor: warnaPalet,
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
            }
        });
        @endif
        } // penutup: if (typeof Chart === 'undefined') { ... } else { ... }
    </script>

@endsection
