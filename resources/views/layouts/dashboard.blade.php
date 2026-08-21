<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PDAM Tirtanadi Padang Bulan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet">

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
        .brand-gradient {
            background: linear-gradient(115deg, #0B6FB4 0%, #14958C 45%, #3FA75B 75%, #8CC63F 100%);
        }
    </style>
</head>

<body class="font-sans text-ink antialiased bg-slate-50" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- ===== SIDEBAR ===== --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-100 flex flex-col transition-transform duration-300">

            <div class="h-16 sm:h-20 flex items-center gap-3 px-5 border-b border-slate-100">
                <img src="{{ asset('images/logo/logo-pdam.jpg') }}" alt="Logo PDAM Tirtanadi"
                    class="w-9 h-9 rounded-full object-cover shrink-0 ring-1 ring-slate-100">
                <div class="leading-tight">
                    <p class="font-display font-bold text-sm">TIRTANADI</p>
                    <p class="text-[10px] text-slate-500">Dashboard Pegawai</p>
                </div>
            </div>

            @php $current = request()->path(); @endphp
            <nav class="flex-1 px-3 py-5 space-y-1 text-sm">
                <a href="/dashboard"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ $current === 'dashboard' ? 'bg-brand-blue/10 text-brand-blue' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="/dashboard/pengaduan"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ str_starts_with($current, 'dashboard/pengaduan') ? 'bg-brand-blue/10 text-brand-blue' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <path d="M14 2v6h6" />
                    </svg>
                    Pengaduan
                </a>
                <span
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-slate-300 cursor-not-allowed">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20.59 13.41L11 3.83V3H3v8h.83L13.41 20.59a2 2 0 002.83 0l4.35-4.35a2 2 0 000-2.83z" />
                    </svg>
                    Kategori <span class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded ml-auto">segera</span>
                </span>
                <span
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-slate-300 cursor-not-allowed">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 17H4v-2a4 4 0 014-4h4" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                    Laporan <span class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded ml-auto">segera</span>
                </span>
            </nav>

            <div class="p-3 border-t border-slate-100">
                <div class="flex items-center gap-3 px-3 py-2.5">
                    <div
                        class="w-9 h-9 rounded-full bg-brand-blue/10 flex items-center justify-center text-brand-blue font-display font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="leading-tight min-w-0">
                        <p class="font-medium text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-red-500 hover:bg-red-50 transition">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <path d="M16 17l5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-30 lg:hidden"
            style="display:none"></div>

        {{-- ===== KONTEN UTAMA ===== --}}
        <div class="flex-1 min-w-0">
            <header
                class="h-16 sm:h-20 bg-white border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
                <button @click="sidebarOpen = true"
                    class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-display font-semibold text-base sm:text-lg text-ink">@yield('title', 'Dashboard')</h1>
                <div class="w-10 lg:hidden"></div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div
                        class="bg-brand-green/10 border border-brand-green/30 text-brand-green rounded-xl p-3.5 mb-6 text-sm font-medium">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
