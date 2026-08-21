<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai — PDAM Tirtanadi Padang Bulan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

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
        .wave-divider { height: 5px; background: linear-gradient(90deg, #0B6FB4, #14958C, #3FA75B, #8CC63F); }
    </style>
</head>
<body class="font-sans text-ink antialiased bg-slate-50 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        {{-- Logo & judul --}}
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo/logo-pdam.jpg') }}" alt="Logo PDAM Tirtanadi" class="w-14 h-14 rounded-full object-cover mx-auto mb-3 ring-1 ring-slate-100">
            <p class="font-display font-bold text-lg text-ink">TIRTANADI</p>
            <p class="text-xs text-slate-500">Dashboard Pegawai &mdash; Cabang Padang Bulan</p>
        </div>

        {{-- Kartu login --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden">
            <div class="wave-divider"></div>

            <div class="p-6 sm:p-8">
                <h1 class="font-display font-bold text-xl text-ink mb-1">Masuk ke Dashboard</h1>
                <p class="text-sm text-slate-500 mb-6">Khusus untuk admin & petugas PDAM Tirtanadi Padang Bulan.</p>

                <form method="POST" action="/login" class="space-y-4" novalidate>
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">NIPP</label>
                        <input type="text" name="nipp" value="{{ old('nipp') }}" autofocus
                               placeholder="Nomor Induk Pegawai"
                               class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2
                                      {{ $errors->has('nipp') ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue' }}">
                        @error('nipp')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Password</label>
                        <input type="password" name="password"
                               placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                               class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2
                                      {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue' }}">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-brand-blue rounded">
                        Ingat saya
                    </label>

                    <button type="submit" class="w-full h-12 rounded-xl bg-brand-blue text-white font-semibold text-sm shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                        Masuk
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            <a href="/" class="hover:text-brand-blue transition">← Kembali ke halaman pelanggan</a>
        </p>
    </div>

</body>
</html>