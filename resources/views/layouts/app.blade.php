<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PDAM Tirtanadi Cabang Padang Bulan')</title>
    <meta name="description" content="@yield('meta_description', 'Sistem pengaduan pelanggan PDAM Tirtanadi Cabang Padang Bulan.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

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
                    screens: { 'xs': '480px' },
                }
            }
        }
    </script>

    <style>
        .wave-divider { height: 5px; background: linear-gradient(90deg, #0B6FB4, #14958C, #3FA75B, #8CC63F); }

        /* Scroll halus + offset supaya section tidak ketutup navbar sticky */
        html { scroll-behavior: smooth; }
        section[id] { scroll-margin-top: 90px; }
    </style>

    @stack('styles')
</head>
<body class="font-sans text-ink antialiased bg-white overflow-x-hidden">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>