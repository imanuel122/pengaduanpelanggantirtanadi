<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PDAM Tirtanadi Padang Bulan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Poppins', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#0B6FB4',
                            bluelight: '#159FDA',
                            teal: '#14958C',
                            green: '#3FA75B',
                            lime: '#8CC63F',
                        },
                        ink: '#12233F',
                    },
                }
            }
        }
    </script>

    <style>
        .brand-gradient { background: linear-gradient(115deg, #0B6FB4 0%, #14958C 45%, #3FA75B 75%, #8CC63F 100%); }

        /* Scrollbar tipis khusus buat area nav sidebar -- murni kosmetik */
        .nav-scroll::-webkit-scrollbar { width: 5px; }
        .nav-scroll::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 999px; }
        .nav-scroll::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="font-sans text-ink antialiased bg-[#F6F8FB]" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- ===== SIDEBAR ===== --}}
        {{-- Selalu 'fixed' (bukan cuma di mobile) supaya sidebar diam di tempat --}}
        {{-- dan gak ikut scroll bareng konten utama di layar besar. --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-100 flex flex-col transition-transform duration-300 shadow-[1px_0_0_0_rgba(15,23,42,0.02)]">

            <div class="h-16 sm:h-20 flex items-center gap-3 px-5 border-b border-slate-100 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-[3px] brand-gradient opacity-90"></div>
                <img src="{{ asset('images/logo/logo-pdam.jpg') }}" alt="Logo PDAM Tirtanadi" class="w-10 h-10 rounded-full object-cover shrink-0 ring-2 ring-brand-blue/10">
                <div class="leading-tight min-w-0">
                    <p class="font-display font-bold text-sm tracking-tight truncate">PDAM TIRTANADI</p>
                    <p class="text-[10px] text-slate-400 font-medium truncate">Cabang Padang Bulan</p>
                </div>
            </div>

            @php
                $current = request()->path();

                // Menu dikelompokkan biar jelas kepakainya buat apa:
                // - "Utama"                -> ringkasan umum
                // - "Penanganan Pengaduan" -> kerjaan harian pegawai/petugas
                // - "Laporan"              -> rekap & analitik
                // - "Administrasi"         -> khusus admin, kelola akun pegawai
                $navGroups = [
                    [
                        'label' => null, // grup pertama gak perlu label, biar gak berasa penuh
                        'items' => [
                            [
                                'href' => '/dashboard',
                                'aktif' => $current === 'dashboard',
                                'label' => 'Dashboard',
                                'icon' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Penanganan Pengaduan',
                        'items' => [
                            [
                                'href' => '/dashboard/pengaduan',
                                'aktif' => str_starts_with($current, 'dashboard/pengaduan'),
                                'label' => 'Pengaduan',
                                'icon' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/>',
                            ],
                            [
                                'href' => '/dashboard/kategori',
                                'aktif' => str_starts_with($current, 'dashboard/kategori'),
                                'label' => 'Kategori',
                                'icon' => '<path d="M20.59 13.41L11 3.83V3H3v8h.83L13.41 20.59a2 2 0 002.83 0l4.35-4.35a2 2 0 000-2.83z"/>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Laporan',
                        'items' => [
                            [
                                'href' => '/dashboard/laporan',
                                'aktif' => str_starts_with($current, 'dashboard/laporan'),
                                'label' => 'Laporan',
                                'icon' => '<path d="M18 20V10M12 20V4M6 20v-6"/>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Administrasi',
                        'adminOnly' => true,
                        'items' => [
                            [
                                'href' => '/dashboard/user',
                                'aktif' => str_starts_with($current, 'dashboard/user'),
                                'label' => 'Manajemen User/Petugas',
                                'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>',
                            ],
                        ],
                    ],
                ];
            @endphp

            <nav class="nav-scroll flex-1 overflow-y-auto px-3 py-4 space-y-4 text-sm">
                @foreach ($navGroups as $group)
                    @continue(($group['adminOnly'] ?? false) && ! auth()->user()->isAdmin())

                    <div>
                        @if ($group['label'])
                            <p class="px-3 pb-1.5 text-[10px] font-bold tracking-widest text-slate-400 uppercase">{{ $group['label'] }}</p>
                        @endif

                        <div class="space-y-0.5">
                            @foreach ($group['items'] as $item)
                                <a href="{{ $item['href'] }}"
                                   class="group flex items-center gap-3 pl-3 pr-3 py-2.5 rounded-xl border-l-[3px] font-medium transition
                                          {{ $item['aktif']
                                                ? 'border-brand-blue bg-gradient-to-r from-brand-blue/10 via-brand-blue/5 to-transparent text-brand-blue font-semibold'
                                                : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-200' }}">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="shrink-0 {{ $item['aktif'] ? '' : 'text-slate-400 group-hover:text-slate-500' }}">
                                        {!! $item['icon'] !!}
                                    </svg>
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="p-3 border-t border-slate-100" x-data="{ profileModalOpen: false }">
                <button type="button" @click="profileModalOpen = true"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition text-left">
                    <div class="w-9 h-9 rounded-full brand-gradient flex items-center justify-center text-white font-display font-bold text-sm shrink-0 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="leading-tight min-w-0 flex-1">
                        <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center mt-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold {{ auth()->user()->role === 'admin' ? 'bg-brand-blue/10 text-brand-blue' : 'bg-slate-100 text-slate-500' }} capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-300 shrink-0"><path d="M9 18l6-6-6-6"/></svg>
                </button>

                {{-- Modal detail profil sendiri -- read-only, tidak bisa diedit/dihapus di sini. --}}
                {{-- Kelola akun (edit/hapus) dilakukan lewat fitur Manajemen User/Petugas. --}}
                <template x-teleport="body">
                    <div x-show="profileModalOpen" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none">
                        <div class="absolute inset-0 bg-ink/50 backdrop-blur-[2px]" @click="profileModalOpen = false"></div>
                        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                            <div class="brand-gradient px-6 pt-6 pb-8 relative">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white font-display font-bold text-base shrink-0 ring-2 ring-white/40">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="leading-tight min-w-0">
                                        <p class="font-display font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-white/80 capitalize">{{ auth()->user()->role }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 pb-6 -mt-4">
                                <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 space-y-3 text-sm">
                                    <div>
                                        <p class="text-xs text-slate-400">NIPP</p>
                                        <p class="font-medium text-ink">{{ auth()->user()->nipp ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Email</p>
                                        <p class="font-medium text-ink break-all">{{ auth()->user()->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">No. Telepon</p>
                                        <p class="font-medium text-ink">{{ auth()->user()->phone ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Role</p>
                                        <p class="font-medium text-ink capitalize">{{ auth()->user()->role }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Bergabung Sejak</p>
                                        <p class="font-medium text-ink">{{ auth()->user()->created_at?->translatedFormat('d F Y') ?? '-' }}</p>
                                    </div>
                                </div>

                                <p class="text-[11px] text-slate-400 mt-4 leading-relaxed">
                                    Profil ini hanya untuk dilihat. Untuk mengubah atau menghapus akun, hubungi admin lewat menu Manajemen User/Petugas.
                                </p>

                                <button type="button" @click="profileModalOpen = false" class="w-full h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition mt-4">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-data="{ confirmLogoutOpen: false }">
                    <button type="button" @click="confirmLogoutOpen = true" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-red-500 hover:bg-red-50 transition mt-1">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                        Keluar
                    </button>

                    {{-- Modal konfirmasi logout -- sengaja di-teleport ke <body>, soalnya <aside> di atas --}}
                    {{-- selalu punya CSS transform aktif (buat animasi geser sidebar di mobile), dan --}}
                    {{-- itu bikin elemen fixed di dalamnya ke-container di situ, bukan ke seluruh layar. --}}
                    <template x-teleport="body">
                        <div x-show="confirmLogoutOpen" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none">
                            <div class="absolute inset-0 bg-ink/50 backdrop-blur-[2px]" @click="confirmLogoutOpen = false"></div>
                            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                                </div>
                                <p class="font-display font-bold text-ink mb-1">Keluar dari Dashboard?</p>
                                <p class="text-sm text-slate-500 mb-5">Anda perlu login lagi untuk mengakses dashboard ini.</p>
                                <div class="flex gap-2">
                                    <button type="button" @click="confirmLogoutOpen = false" class="flex-1 h-11 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                                        Batal
                                    </button>
                                    <form method="POST" action="/logout" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full h-11 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                                            Ya, Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-ink/40 backdrop-blur-[1px] z-30 lg:hidden" style="display:none"></div>

        {{-- ===== KONTEN UTAMA ===== --}}
        <div class="flex-1 min-w-0 lg:ml-64">
            <header class="h-16 sm:h-20 bg-white/90 backdrop-blur border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
                <div class="flex items-center gap-3 min-w-0">
                    <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 shrink-0 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <span class="hidden sm:block w-1.5 h-6 rounded-full brand-gradient shrink-0"></span>
                    <h1 class="font-display font-semibold text-base sm:text-lg text-ink truncate">@yield('title', 'Dashboard')</h1>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="flex items-start gap-2.5 bg-brand-green/10 border border-brand-green/25 text-brand-green rounded-xl p-3.5 mb-6 text-sm font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5"><path d="M20 6L9 17l-5-5"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flex items-start gap-2.5 bg-red-50 border border-red-200 text-red-600 rounded-xl p-3.5 mb-6 text-sm font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v5M12 16h.01"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
