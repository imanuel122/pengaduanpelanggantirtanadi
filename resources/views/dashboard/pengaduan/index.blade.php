@extends('layouts.dashboard')

@section('title', 'Kelola Pengaduan')

@section('content')

    {{-- Tab filter status --}}
    @php
        $tabs = [
            'semua' => 'Semua',
            'baru' => 'Baru',
            'pengecekan' => 'Pengecekan',
            'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];
        $statusAktif = $statusFilter ?? 'semua';
    @endphp

    <div class="flex flex-wrap gap-2 mb-5">
        @foreach ($tabs as $key => $label)
            @php
                $url = $key === 'semua' ? '/dashboard/pengaduan' : '/dashboard/pengaduan?status=' . $key;
                $aktif = $statusAktif === $key;
            @endphp
            <a href="{{ $url }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition {{ $aktif ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'bg-white text-slate-500 border border-slate-200 hover:border-brand-blue/40' }}">
                {{ $label }}
                <span class="{{ $aktif ? 'bg-white/20' : 'bg-slate-100' }} px-1.5 py-0.5 rounded-full text-[10px]">{{ $jumlahPerStatus[$key] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="/dashboard/pengaduan" class="flex gap-2 mb-5">
        @if ($statusAktif !== 'semua')
            <input type="hidden" name="status" value="{{ $statusAktif }}">
        @endif
        <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nomor pengaduan, nama pelapor, atau judul..."
               class="flex-1 h-11 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition bg-white">
        <button type="submit" class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-sm font-semibold text-slate-600 hover:border-brand-blue/40 transition">
            Cari
        </button>
    </form>

    {{-- Tabel/list pengaduan --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="divide-y divide-slate-50">
            @forelse ($pengaduans as $item)
                <a href="/dashboard/pengaduan/{{ $item->id }}" class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 justify-between px-4 sm:px-5 py-4 hover:bg-slate-50 transition">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-xs font-mono text-brand-blue font-semibold">{{ $item->kode_pengaduan }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $item->statusColor() }}">
                                {{ $item->statusLabel() }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-ink mt-1 truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->nama_pelapor }} &middot; {{ $item->kategori->nama ?? '-' }}
                            @if ($item->petugas)
                                &middot; Petugas: {{ $item->petugas->name }}
                            @endif
                        </p>
                    </div>
                    <div class="text-xs text-slate-400 sm:text-right shrink-0">
                        {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-400 px-5 py-12 text-center">
                    @if ($cari)
                        Tidak ada pengaduan yang cocok dengan pencarian "{{ $cari }}".
                    @else
                        Belum ada pengaduan di kategori ini.
                    @endif
                </p>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-5">
        {{ $pengaduans->links() }}
    </div>

@endsection