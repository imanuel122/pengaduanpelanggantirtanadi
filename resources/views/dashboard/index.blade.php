@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <p class="text-slate-500 text-sm mb-6">Selamat datang, {{ auth()->user()->name }} 👋</p>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <a href="/dashboard/pengaduan" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Total Pengaduan</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-ink mt-1">{{ $stats['total'] }}</p>
        </a>
        <a href="/dashboard/pengaduan?status=baru" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Baru</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-brand-blue mt-1">{{ $stats['baru'] }}</p>
        </a>
        <a href="/dashboard/pengaduan?status=diverifikasi" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Diverifikasi</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-amber-500 mt-1">{{ $stats['diverifikasi'] }}</p>
        </a>
        <a href="/dashboard/pengaduan?status=diproses" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Diproses</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-brand-teal mt-1">{{ $stats['diproses'] }}</p>
        </a>
        <a href="/dashboard/pengaduan?status=selesai" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Selesai</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-brand-green mt-1">{{ $stats['selesai'] }}</p>
        </a>
        <a href="/dashboard/pengaduan?status=ditolak" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition">
            <p class="text-xs text-slate-400">Ditolak</p>
            <p class="font-display font-bold text-2xl sm:text-3xl text-red-500 mt-1">{{ $stats['ditolak'] }}</p>
        </a>
    </div>

    {{-- Pengaduan terbaru --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <p class="font-display font-semibold text-ink">Pengaduan Terbaru</p>
            <a href="/dashboard/pengaduan" class="text-xs font-semibold text-brand-blue hover:underline">Lihat Semua →</a>
        </div>

        <div class="divide-y divide-slate-50">
            @forelse ($terbaru as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->kode_pengaduan }} &middot; {{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}
                        </p>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->statusColor() }}">
                        {{ $item->statusLabel() }}
                    </span>
                </a>
            @empty
                <p class="text-sm text-slate-400 px-5 py-8 text-center">Belum ada pengaduan masuk.</p>
            @endforelse
        </div>
    </div>

@endsection