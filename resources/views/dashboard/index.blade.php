@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    @php
        $jam = (int) now()->format('H');
        $sapaan = match (true) {
            $jam < 11 => 'Selamat pagi',
            $jam < 15 => 'Selamat siang',
            $jam < 19 => 'Selamat sore',
            default => 'Selamat malam',
        };

        // Kartu statistik: ikon, warna, dan link-nya dikumpulkan di satu tempat
        // biar gampang dibaca -- datanya sendiri (jumlah) tetap murni dari
        // $stats yang sama seperti sebelumnya, tidak ada perhitungan baru.
        $statCards = [
            [
                'label' => 'Total Pengaduan',
                'value' => $stats['total'],
                'href' => '/dashboard/pengaduan',
                'accent' => 'text-ink',
                'badgeBg' => 'bg-ink/5',
                'badgeText' => 'text-ink',
                'icon' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
            ],
            [
                'label' => 'Baru',
                'value' => $stats['baru'],
                'href' => '/dashboard/pengaduan?status=baru',
                'accent' => 'text-brand-blue',
                'badgeBg' => 'bg-brand-blue/10',
                'badgeText' => 'text-brand-blue',
                'icon' => '<path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6l-3.45-6.89A2 2 0 0016.76 4H7.24a2 2 0 00-1.79 1.11z"/>',
            ],
            [
                'label' => 'Diverifikasi',
                'value' => $stats['diverifikasi'],
                'href' => '/dashboard/pengaduan?status=diverifikasi',
                'accent' => 'text-amber-500',
                'badgeBg' => 'bg-amber-50',
                'badgeText' => 'text-amber-500',
                'icon' => '<path d="M9 12l2 2 4-4"/><path d="M12 3l8 4v5c0 4.5-3 8-8 9-5-1-8-4.5-8-9V7z"/>',
            ],
            [
                'label' => 'Diproses',
                'value' => $stats['diproses'],
                'href' => '/dashboard/pengaduan?status=diproses',
                'accent' => 'text-brand-teal',
                'badgeBg' => 'bg-brand-teal/10',
                'badgeText' => 'text-brand-teal',
                'icon' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
            ],
            [
                'label' => 'Selesai',
                'value' => $stats['selesai'],
                'href' => '/dashboard/pengaduan?status=selesai',
                'accent' => 'text-brand-green',
                'badgeBg' => 'bg-brand-green/10',
                'badgeText' => 'text-brand-green',
                'icon' => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/>',
            ],
            [
                'label' => 'Ditolak',
                'value' => $stats['ditolak'],
                'href' => '/dashboard/pengaduan?status=ditolak',
                'accent' => 'text-red-500',
                'badgeBg' => 'bg-red-50',
                'badgeText' => 'text-red-500',
                'icon' => '<circle cx="12" cy="12" r="9"/><path d="M15 9l-6 6M9 9l6 6"/>',
            ],
        ];
    @endphp

    {{-- ===== BANNER SAMBUTAN ===== --}}
    {{-- Motif gelombang di bagian bawah -- ngasih sentuhan "air" yang relevan --}}
    {{-- sama identitas PDAM, sekaligus jadi elemen visual pembeda halaman ini. --}}
    <div class="relative rounded-3xl overflow-hidden brand-gradient mb-6 sm:mb-8">
        <div class="relative z-10 px-5 sm:px-8 pt-6 sm:pt-8 pb-12 sm:pb-14">
            <p class="text-white/80 text-xs sm:text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
            <h2 class="font-display font-bold text-white text-xl sm:text-2xl lg:text-3xl mt-1 tracking-tight">
                {{ $sapaan }}, {{ explode(' ', auth()->user()->name)[0] }}
            </h2>
            <p class="text-white/85 text-xs sm:text-sm mt-2 max-w-md">
                @if ($stats['baru'] > 0)
                    Ada <span class="font-semibold text-white">{{ $stats['baru'] }} pengaduan baru</span> yang menunggu ditindaklanjuti hari ini.
                @else
                    Semua pengaduan baru sudah ditindaklanjuti. Kerja bagus!
                @endif
            </p>
        </div>

        {{-- Gelombang air --}}
        <svg class="absolute bottom-0 left-0 w-full h-10 sm:h-14 text-[#F6F8FB]" viewBox="0 0 1440 100" preserveAspectRatio="none" fill="currentColor">
            <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,100 1440,50 L1440,100 L0,100 Z"/>
        </svg>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6 sm:mb-8">
        @foreach ($statCards as $card)
            <a href="{{ $card['href'] }}" class="group bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $card['badgeBg'] }} {{ $card['badgeText'] }} flex items-center justify-center mb-3">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $card['icon'] !!}</svg>
                </div>
                <p class="text-xs text-slate-400 font-medium truncate">{{ $card['label'] }}</p>
                <p class="font-display font-bold text-2xl sm:text-3xl {{ $card['accent'] }} mt-0.5 tracking-tight">{{ $card['value'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- ===== PENGADUAN TERBARU ===== --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <p class="font-display font-semibold text-ink">Pengaduan Terbaru</p>
                <p class="text-xs text-slate-400 mt-0.5">8 laporan pelanggan yang paling baru masuk</p>
            </div>
            <a href="/dashboard/pengaduan" class="shrink-0 inline-flex items-center gap-1 text-xs font-semibold text-brand-blue hover:underline">
                Lihat Semua
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg>
            </a>
        </div>

        <div class="divide-y divide-slate-50">
            @forelse ($terbaru as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center gap-3 sm:gap-4 px-5 py-3.5 hover:bg-slate-50 transition">
                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-display font-bold text-xs shrink-0">
                        {{ strtoupper(substr($item->nama_pelapor, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-ink truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 truncate">
                            {{ $item->kode_pengaduan }} &middot; {{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}
                        </p>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                </a>
            @empty
                <div class="text-center px-5 py-12">
                    <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
                    </div>
                    <p class="text-sm text-slate-400">Belum ada pengaduan masuk.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
