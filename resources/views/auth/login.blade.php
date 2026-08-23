<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Pegawai — PDAM Tirtanadi Padang Bulan</title>

    {{-- =========================================================
         GOOGLE FONT
    ========================================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
         TAILWIND CSS
    ========================================================== --}}
    <script src="https://cdn.tailwindcss.com"></script>


    {{-- =========================================================
         ALPINE JS
    ========================================================== --}}
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>


    {{-- =========================================================
         TAILWIND CONFIG
    ========================================================== --}}
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

                    boxShadow: {

                        soft: '0 25px 70px rgba(18, 35, 63, 0.13)',

                    }

                }

            }

        }

    </script>


    {{-- =========================================================
         CUSTOM CSS
    ========================================================== --}}
    <style>

        * {
            -webkit-tap-highlight-color: transparent;
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            background:

                radial-gradient(
                    circle at 10% 10%,
                    rgba(21, 159, 218, 0.08),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 90%,
                    rgba(140, 198, 63, 0.08),
                    transparent 30%
                ),

                #f8fafc;
        }

        [x-cloak] {
            display: none !important;
        }


        /* =====================================================
           GRADIENT KHAS TIRTANADI
        ====================================================== */

        .pdam-gradient {

            background:

                linear-gradient(
                    135deg,
                    #075B99 0%,
                    #0B6FB4 25%,
                    #14958C 55%,
                    #3FA75B 80%,
                    #8CC63F 100%
                );

        }


        /* =====================================================
           GLOW BACKGROUND
        ====================================================== */

        .hero-glow {

            position: absolute;

            border-radius: 9999px;

            background: rgba(255, 255, 255, 0.10);

            filter: blur(1px);

        }


        /* =====================================================
           CIRCLE DECORATION
        ====================================================== */

        .hero-circle {

            position: absolute;

            border-radius: 9999px;

            border: 1px solid rgba(255,255,255,0.10);

        }


        /* =====================================================
           WATER WAVE
        ====================================================== */

        .water-wave {

            position: absolute;

            left: -5%;

            bottom: -5px;

            width: 110%;

            height: 190px;

            opacity: 0.95;

        }

        .water-wave svg {

            width: 100%;

            height: 100%;

            display: block;

        }


        /* =====================================================
           FLOATING BUBBLE
        ====================================================== */

        .bubble {

            position: absolute;

            border-radius: 9999px;

            border: 1px solid rgba(255,255,255,0.18);

            background: rgba(255,255,255,0.04);

            animation: floatBubble 7s ease-in-out infinite;

        }

        .bubble-delay-1 {
            animation-delay: -2s;
        }

        .bubble-delay-2 {
            animation-delay: -4s;
        }

        .bubble-delay-3 {
            animation-delay: -6s;
        }


        @keyframes floatBubble {

            0%,
            100% {

                transform:
                    translateY(0)
                    translateX(0);

            }

            50% {

                transform:
                    translateY(-18px)
                    translateX(8px);

            }

        }


        /* =====================================================
           WATER DROPS
        ====================================================== */

        .drop {

            animation:
                dropFloat
                4s
                ease-in-out
                infinite;

        }


        @keyframes dropFloat {

            0%,
            100% {

                transform: translateY(0);

                opacity: .45;

            }

            50% {

                transform: translateY(-12px);

                opacity: .8;

            }

        }


        /* =====================================================
           LOGIN CARD
        ====================================================== */

        .login-card {

            box-shadow:

                0 25px 70px
                rgba(18, 35, 63, 0.12),

                0 5px 20px
                rgba(18, 35, 63, 0.04);

        }


        /* =====================================================
           INPUT
        ====================================================== */

        .login-input {

            transition:

                border-color .2s ease,

                box-shadow .2s ease,

                background-color .2s ease;

        }


        .login-input:focus {

            background-color: #ffffff;

            box-shadow:

                0 0 0 4px
                rgba(11, 111, 180, 0.09);

        }


        /* =====================================================
           LOGIN BUTTON
        ====================================================== */

        .login-button {

            background:

                linear-gradient(
                    100deg,
                    #0B6FB4,
                    #14958C,
                    #3FA75B
                );

            background-size: 200% 100%;

            transition:

                background-position .4s ease,

                transform .2s ease,

                box-shadow .2s ease;

        }


        .login-button:hover {

            background-position: 100% 0;

            transform: translateY(-1px);

            box-shadow:

                0 12px 25px
                rgba(11, 111, 180, 0.22);

        }


        .login-button:active {

            transform: translateY(0);

        }


        /* =====================================================
           VALUE CARD
        ====================================================== */

        .value-card {

            background: rgba(255,255,255,0.10);

            border:
                1px solid
                rgba(255,255,255,0.12);

            backdrop-filter: blur(8px);

            -webkit-backdrop-filter: blur(8px);

            transition:

                transform .25s ease,

                background-color .25s ease;

        }


        .value-card:hover {

            transform: translateY(-3px);

            background:
                rgba(255,255,255,0.15);

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1023px) {

            body {
                background: #f8fafc;
            }

        }

    </style>

</head>


<body class="font-sans text-ink antialiased min-h-screen">


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main
        class="min-h-screen flex items-center justify-center p-3 sm:p-5 lg:p-8"
    >


        {{-- =====================================================
             MAIN CARD
        ====================================================== --}}

        <div
            class="
                login-card
                w-full
                max-w-6xl
                bg-white
                rounded-[1.75rem]
                sm:rounded-[2rem]
                overflow-hidden
                border
                border-slate-100
            "
        >


            <div
                class="
                    grid
                    lg:grid-cols-[1.05fr_0.95fr]
                    min-h-[680px]
                "
            >


                {{-- =================================================
                     LEFT / BRANDING TIRTANADI
                ================================================== --}}

                <section
                    class="
                        relative
                        hidden
                        lg:flex
                        pdam-gradient
                        overflow-hidden
                        text-white
                    "
                >


                    {{-- =================================================
                         BACKGROUND GLOW
                    ================================================== --}}

                    <div
                        class="
                            hero-glow
                            w-[420px]
                            h-[420px]
                            -top-48
                            -left-48
                        "
                    ></div>


                    <div
                        class="
                            hero-glow
                            w-[320px]
                            h-[320px]
                            bottom-[-130px]
                            right-[-100px]
                        "
                    ></div>


                    {{-- =================================================
                         DECORATIVE CIRCLES
                    ================================================== --}}

                    <div
                        class="
                            hero-circle
                            w-[180px]
                            h-[180px]
                            top-[32%]
                            right-[10%]
                        "
                    ></div>


                    <div
                        class="
                            hero-circle
                            w-[110px]
                            h-[110px]
                            top-[39%]
                            right-[15%]
                        "
                    ></div>


                    <div
                        class="
                            hero-circle
                            w-[60px]
                            h-[60px]
                            top-[27%]
                            right-[28%]
                        "
                    ></div>


                    {{-- =================================================
                         FLOATING BUBBLES
                    ================================================== --}}

                    <div
                        class="
                            bubble
                            w-7
                            h-7
                            top-[20%]
                            right-[23%]
                        "
                    ></div>


                    <div
                        class="
                            bubble
                            bubble-delay-1
                            w-4
                            h-4
                            top-[30%]
                            right-[8%]
                        "
                    ></div>


                    <div
                        class="
                            bubble
                            bubble-delay-2
                            w-10
                            h-10
                            top-[14%]
                            right-[7%]
                        "
                    ></div>


                    <div
                        class="
                            bubble
                            bubble-delay-3
                            w-5
                            h-5
                            top-[48%]
                            left-[12%]
                        "
                    ></div>


                    {{-- =================================================
                         CONTENT
                    ================================================== --}}

                    <div
                        class="
                            relative
                            z-20
                            w-full
                            flex
                            flex-col
                            p-10
                            xl:p-14
                        "
                    >


                        {{-- =================================================
                             LOGO
                        ================================================== --}}

                        <div class="flex items-center gap-4">


                            <div
                                class="
                                    w-[62px]
                                    h-[62px]
                                    rounded-2xl
                                    bg-white
                                    p-1.5
                                    shadow-xl
                                    shadow-black/10
                                "
                            >

                                <img
                                    src="{{ asset('images/logo/logo-pdam.jpg') }}"
                                    alt="Logo PDAM Tirtanadi"
                                    class="
                                        w-full
                                        h-full
                                        object-cover
                                        rounded-xl
                                    "
                                >

                            </div>


                            <div>

                                <p
                                    class="
                                        font-display
                                        font-bold
                                        text-xl
                                        tracking-wide
                                    "
                                >
                                    TIRTANADI
                                </p>


                                <p
                                    class="
                                        text-sm
                                        text-white/70
                                        mt-0.5
                                    "
                                >
                                    Cabang Padang Bulan
                                </p>

                            </div>

                        </div>


                        {{-- =================================================
                             HERO CONTENT
                        ================================================== --}}

                        <div
                            class="
                                relative
                                mt-auto
                                mb-auto
                                max-w-xl
                            "
                        >


                            {{-- Badge --}}

                            <div
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    px-3.5
                                    py-2
                                    rounded-full
                                    bg-white/10
                                    border
                                    border-white/15
                                    backdrop-blur-sm
                                    mb-7
                                "
                            >

                                <span
                                    class="
                                        w-2
                                        h-2
                                        rounded-full
                                        bg-lime-300
                                        shadow-[0_0_10px_rgba(163,230,53,.8)]
                                    "
                                ></span>


                                <span
                                    class="
                                        text-xs
                                        font-medium
                                        text-white/90
                                    "
                                >
                                    Sistem Internal Pegawai
                                </span>

                            </div>


                            {{-- =================================================
                                 TAGLINE UTAMA
                            ================================================== --}}

                            <h1
                                class="
                                    font-display
                                    font-bold
                                    text-5xl
                                    xl:text-[58px]
                                    leading-[1.05]
                                    tracking-tight
                                "
                            >

                                Mengalir

                                <br>

                                <span class="text-lime-200">
                                    Melengkapi Hari.
                                </span>

                            </h1>


                            {{-- =================================================
                                 TAGLINE SUBTITLE
                            ================================================== --}}

                            <p
                                class="
                                    mt-5
                                    text-lg
                                    font-medium
                                    text-white/90
                                "
                            >
                                Air bersih untuk kehidupan yang lebih baik.
                            </p>


                            {{-- =================================================
                                 DESKRIPSI
                            ================================================== --}}

                            <p
                                class="
                                    mt-5
                                    text-sm
                                    xl:text-base
                                    text-white/75
                                    leading-relaxed
                                    max-w-md
                                "
                            >

                                Tirtanadi berkomitmen memberikan pelayanan
                                air minum yang profesional, andal, dan
                                berkelanjutan untuk memenuhi kebutuhan
                                masyarakat setiap hari.

                            </p>


                            {{-- =================================================
                                 NILAI TAGLINE
                            ================================================== --}}

                            <div
                                class="
                                    grid
                                    grid-cols-3
                                    gap-3
                                    mt-8
                                    max-w-md
                                "
                            >


                                {{-- Mengalir --}}

                                <div
                                    class="
                                        value-card
                                        rounded-xl
                                        p-3.5
                                        text-center
                                    "
                                >

                                    <div
                                        class="
                                            w-9
                                            h-9
                                            mx-auto
                                            rounded-xl
                                            bg-white/10
                                            flex
                                            items-center
                                            justify-center
                                            mb-2.5
                                        "
                                    >

                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <path
                                                d="M3 12c2.5-3 5-3 7.5 0s5 3 7.5 0 4.5-3 6-1"
                                            ></path>

                                            <path
                                                d="M3 17c2.5-3 5-3 7.5 0s5 3 7.5 0 4.5-3 6-1"
                                            ></path>

                                        </svg>

                                    </div>


                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                        "
                                    >
                                        Mengalir
                                    </p>


                                    <p
                                        class="
                                            text-[10px]
                                            text-white/60
                                            mt-1
                                        "
                                    >
                                        Terus melayani
                                    </p>

                                </div>


                                {{-- Melengkapi --}}

                                <div
                                    class="
                                        value-card
                                        rounded-xl
                                        p-3.5
                                        text-center
                                    "
                                >

                                    <div
                                        class="
                                            w-9
                                            h-9
                                            mx-auto
                                            rounded-xl
                                            bg-white/10
                                            flex
                                            items-center
                                            justify-center
                                            mb-2.5
                                        "
                                    >

                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            ></circle>

                                            <path
                                                d="M8 12l2.5 2.5L16 9"
                                            ></path>

                                        </svg>

                                    </div>


                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                        "
                                    >
                                        Melengkapi
                                    </p>


                                    <p
                                        class="
                                            text-[10px]
                                            text-white/60
                                            mt-1
                                        "
                                    >
                                        Penuhi kebutuhan
                                    </p>

                                </div>


                                {{-- Hari --}}

                                <div
                                    class="
                                        value-card
                                        rounded-xl
                                        p-3.5
                                        text-center
                                    "
                                >

                                    <div
                                        class="
                                            w-9
                                            h-9
                                            mx-auto
                                            rounded-xl
                                            bg-white/10
                                            flex
                                            items-center
                                            justify-center
                                            mb-2.5
                                        "
                                    >

                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            ></circle>

                                            <path
                                                d="M12 7v5l3 2"
                                            ></path>

                                        </svg>

                                    </div>


                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                        "
                                    >
                                        Hari
                                    </p>


                                    <p
                                        class="
                                            text-[10px]
                                            text-white/60
                                            mt-1
                                        "
                                    >
                                        Setiap hari
                                    </p>

                                </div>


                            </div>

                        </div>


                        {{-- =================================================
                             FOOTER KIRI
                        ================================================== --}}

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                relative
                                z-30
                            "
                        >

                            <div
                                class="
                                    text-xs
                                    text-white/55
                                "
                            >
                                © {{ date('Y') }} PDAM Tirtanadi
                            </div>


                            <div
                                class="
                                    flex
                                    items-center
                                    gap-2
                                    text-xs
                                    text-white/55
                                "
                            >

                                <span
                                    class="
                                        w-1.5
                                        h-1.5
                                        rounded-full
                                        bg-lime-300
                                    "
                                ></span>

                                Padang Bulan

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         WATER WAVE
                    ================================================== --}}

                    <div class="water-wave">

                        <svg
                            viewBox="0 0 1440 220"
                            preserveAspectRatio="none"
                        >

                            <path
                                d="
                                    M0,130
                                    C180,80 270,170 450,125
                                    C620,80 720,145 900,105
                                    C1080,65 1210,145 1440,90
                                    L1440,220
                                    L0,220
                                    Z
                                "
                                fill="rgba(255,255,255,0.07)"
                            />


                            <path
                                d="
                                    M0,155
                                    C190,105 300,190 500,145
                                    C680,105 790,170 970,125
                                    C1150,80 1280,160 1440,110
                                    L1440,220
                                    L0,220
                                    Z
                                "
                                fill="rgba(255,255,255,0.08)"
                            />


                            <path
                                d="
                                    M0,180
                                    C180,130 330,205 530,165
                                    C730,125 850,185 1030,145
                                    C1210,105 1320,180 1440,140
                                    L1440,220
                                    L0,220
                                    Z
                                "
                                fill="rgba(255,255,255,0.10)"
                            />

                        </svg>

                    </div>


                    {{-- =================================================
                         WATER DROPS
                    ================================================== --}}

                    <div
                        class="
                            drop
                            absolute
                            bottom-[145px]
                            left-[24%]
                            w-2
                            h-2
                            rounded-full
                            bg-white/40
                        "
                    ></div>


                    <div
                        class="
                            drop
                            absolute
                            bottom-[120px]
                            left-[31%]
                            w-1.5
                            h-1.5
                            rounded-full
                            bg-white/30
                        "
                    ></div>


                    <div
                        class="
                            drop
                            absolute
                            bottom-[160px]
                            left-[38%]
                            w-2.5
                            h-2.5
                            rounded-full
                            bg-white/30
                        "
                    ></div>


                </section>



                {{-- =================================================
                     RIGHT / LOGIN
                ================================================== --}}

                <section
                    class="
                        flex
                        items-center
                        justify-center
                        p-6
                        sm:p-10
                        lg:p-12
                        xl:p-14
                        bg-white
                    "
                >

                    <div class="w-full max-w-md">


                        {{-- =================================================
                             MOBILE LOGO
                        ================================================== --}}

                        <div
                            class="
                                lg:hidden
                                text-center
                                mb-9
                            "
                        >

                            <div
                                class="
                                    inline-flex
                                    w-[76px]
                                    h-[76px]
                                    p-1.5
                                    rounded-2xl
                                    bg-white
                                    shadow-lg
                                    border
                                    border-slate-100
                                "
                            >

                                <img
                                    src="{{ asset('images/logo/logo-pdam.jpg') }}"
                                    alt="Logo PDAM Tirtanadi"
                                    class="
                                        w-full
                                        h-full
                                        object-cover
                                        rounded-xl
                                    "
                                >

                            </div>


                            <p
                                class="
                                    font-display
                                    font-bold
                                    text-xl
                                    text-ink
                                    mt-4
                                "
                            >
                                TIRTANADI
                            </p>


                            <p
                                class="
                                    text-xs
                                    text-slate-500
                                    mt-1
                                "
                            >
                                Cabang Padang Bulan
                            </p>

                        </div>



                        {{-- =================================================
                             LOGIN HEADER
                        ================================================== --}}

                        <div class="mb-8">


                            <div
                                class="
                                    w-11
                                    h-11
                                    rounded-xl
                                    p-[1px]
                                    bg-gradient-to-br
                                    from-brand-blue
                                    via-brand-teal
                                    to-brand-green
                                    mb-5
                                    shadow-lg
                                    shadow-brand-blue/15
                                "
                            >

                                <div
                                    class="
                                        w-full
                                        h-full
                                        rounded-[11px]
                                        bg-white
                                        flex
                                        items-center
                                        justify-center
                                        text-brand-blue
                                    "
                                >

                                    <svg
                                        width="21"
                                        height="21"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >

                                        <path
                                            d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"
                                        ></path>

                                        <polyline
                                            points="10 17 15 12 10 7"
                                        ></polyline>

                                        <line
                                            x1="15"
                                            y1="12"
                                            x2="3"
                                            y2="12"
                                        ></line>

                                    </svg>

                                </div>

                            </div>


                            <h2
                                class="
                                    font-display
                                    text-2xl
                                    sm:text-3xl
                                    font-bold
                                    text-ink
                                    tracking-tight
                                "
                            >
                                Selamat datang kembali
                            </h2>


                            <p
                                class="
                                    text-sm
                                    text-slate-500
                                    mt-2
                                    leading-relaxed
                                "
                            >
                                Masuk ke dashboard pegawai untuk melanjutkan
                                pekerjaan Anda.
                            </p>

                        </div>



                        {{-- =================================================
                             FORM LOGIN
                        ================================================== --}}

                        <form
                            method="POST"
                            action="/login"
                            class="space-y-5"
                            novalidate
                        >

                            @csrf


                            {{-- =================================================
                                 NIPP
                            ================================================== --}}

                            <div>

                                <label
                                    for="nipp"
                                    class="
                                        block
                                        text-sm
                                        font-semibold
                                        text-ink
                                        mb-2
                                    "
                                >
                                    NIPP
                                </label>


                                <div class="relative">


                                    {{-- Icon --}}

                                    <div
                                        class="
                                            absolute
                                            left-0
                                            top-0
                                            h-12
                                            w-12
                                            flex
                                            items-center
                                            justify-center
                                            text-slate-400
                                            pointer-events-none
                                        "
                                    >

                                        <svg
                                            width="19"
                                            height="19"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <path
                                                d="
                                                    M20 21v-2
                                                    a4 4 0 0 0-4-4H8
                                                    a4 4 0 0 0-4 4v2
                                                "
                                            ></path>

                                            <circle
                                                cx="12"
                                                cy="7"
                                                r="4"
                                            ></circle>

                                        </svg>

                                    </div>


                                    {{-- Input --}}

                                    <input
                                        id="nipp"
                                        type="text"
                                        name="nipp"
                                        value="{{ old('nipp') }}"
                                        autofocus
                                        autocomplete="username"
                                        placeholder="Masukkan NIPP Anda"

                                        class="
                                            login-input
                                            w-full
                                            h-12
                                            rounded-xl
                                            border
                                            bg-slate-50/70
                                            pl-12
                                            pr-4
                                            text-sm
                                            text-ink
                                            placeholder:text-slate-400
                                            outline-none

                                            {{ $errors->has('nipp')
                                                ? 'border-red-400 focus:border-red-400 focus:ring-2 focus:ring-red-400/10'
                                                : 'border-slate-200 focus:border-brand-blue'
                                            }}
                                        "
                                    >

                                </div>


                                @error('nipp')

                                    <p
                                        class="
                                            text-red-500
                                            text-xs
                                            mt-2
                                            flex
                                            items-center
                                            gap-1.5
                                        "
                                    >

                                        <svg
                                            width="13"
                                            height="13"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>

                                            <line
                                                x1="12"
                                                y1="8"
                                                x2="12"
                                                y2="12"
                                            ></line>

                                            <line
                                                x1="12"
                                                y1="16"
                                                x2="12.01"
                                                y2="16"
                                            ></line>

                                        </svg>

                                        {{ $message }}

                                    </p>

                                @enderror

                            </div>



                            {{-- =================================================
                                 PASSWORD
                            ================================================== --}}

                            <div
                                x-data="{ showPassword: false }"
                            >


                                <label
                                    for="password"
                                    class="
                                        block
                                        text-sm
                                        font-semibold
                                        text-ink
                                        mb-2
                                    "
                                >
                                    Password
                                </label>


                                <div class="relative">


                                    {{-- Lock Icon --}}

                                    <div
                                        class="
                                            absolute
                                            left-0
                                            top-0
                                            h-12
                                            w-12
                                            flex
                                            items-center
                                            justify-center
                                            text-slate-400
                                            pointer-events-none
                                        "
                                    >

                                        <svg
                                            width="19"
                                            height="19"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <rect
                                                x="3"
                                                y="11"
                                                width="18"
                                                height="10"
                                                rx="2"
                                            ></rect>

                                            <path
                                                d="M7 11V7a5 5 0 0 1 10 0v4"
                                            ></path>

                                        </svg>

                                    </div>


                                    {{-- Password Input --}}

                                    <input
                                        id="password"
                                        :type="
                                            showPassword
                                                ? 'text'
                                                : 'password'
                                        "
                                        name="password"
                                        autocomplete="current-password"
                                        placeholder="Masukkan password"

                                        class="
                                            login-input
                                            w-full
                                            h-12
                                            rounded-xl
                                            border
                                            bg-slate-50/70
                                            pl-12
                                            pr-12
                                            text-sm
                                            text-ink
                                            placeholder:text-slate-400
                                            outline-none

                                            {{ $errors->has('password')
                                                ? 'border-red-400 focus:border-red-400 focus:ring-2 focus:ring-red-400/10'
                                                : 'border-slate-200 focus:border-brand-blue'
                                            }}
                                        "
                                    >


                                    {{-- Eye Button --}}

                                    <button
                                        type="button"
                                        @click="
                                            showPassword = !showPassword
                                        "

                                        class="
                                            absolute
                                            right-0
                                            top-0
                                            h-12
                                            w-12
                                            flex
                                            items-center
                                            justify-center
                                            text-slate-400
                                            hover:text-brand-blue
                                            transition
                                            focus:outline-none
                                        "

                                        :aria-label="
                                            showPassword
                                                ? 'Sembunyikan password'
                                                : 'Tampilkan password'
                                        "
                                    >


                                        {{-- Eye --}}

                                        <svg
                                            x-show="!showPassword"
                                            x-cloak

                                            width="19"
                                            height="19"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <path
                                                d="
                                                    M1 12s4-8 11-8
                                                    11 8 11 8
                                                    -4 8-11 8
                                                    -11-8-11-8z
                                                "
                                            ></path>

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                            ></circle>

                                        </svg>


                                        {{-- Eye Off --}}

                                        <svg
                                            x-show="showPassword"
                                            x-cloak

                                            width="19"
                                            height="19"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >

                                            <path
                                                d="
                                                    M17.94 17.94
                                                    A10.94 10.94 0 0 1 12 20
                                                    c-7 0-11-8-11-8
                                                    a18.5 18.5 0 0 1 5.06-5.94
                                                "
                                            ></path>

                                            <path
                                                d="
                                                    M9.9 4.24
                                                    A9.12 9.12 0 0 1 12 4
                                                    c7 0 11 8 11 8
                                                    a18.5 18.5 0 0 1-2.16 3.19
                                                "
                                            ></path>

                                            <path
                                                d="
                                                    M14.12 14.12
                                                    a3 3 0 1 1-4.24-4.24
                                                "
                                            ></path>

                                            <line
                                                x1="1"
                                                y1="1"
                                                x2="23"
                                                y2="23"
                                            ></line>

                                        </svg>


                                    </button>

                                </div>


                                @error('password')

                                    <p
                                        class="
                                            text-red-500
                                            text-xs
                                            mt-2
                                            flex
                                            items-center
                                            gap-1.5
                                        "
                                    >

                                        <svg
                                            width="13"
                                            height="13"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>

                                            <line
                                                x1="12"
                                                y1="8"
                                                x2="12"
                                                y2="12"
                                            ></line>

                                            <line
                                                x1="12"
                                                y1="16"
                                                x2="12.01"
                                                y2="16"
                                            ></line>

                                        </svg>

                                        {{ $message }}

                                    </p>

                                @enderror

                            </div>



                            {{-- =================================================
                                 REMEMBER ME
                            ================================================== --}}

                            <label
                                class="
                                    flex
                                    items-center
                                    gap-2.5
                                    text-sm
                                    text-slate-600
                                    cursor-pointer
                                    select-none
                                "
                            >

                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="
                                        w-4
                                        h-4
                                        rounded
                                        border-slate-300
                                        accent-brand-blue
                                        cursor-pointer
                                    "
                                >

                                <span>
                                    Ingat saya
                                </span>

                            </label>



                            {{-- =================================================
                                 LOGIN BUTTON
                            ================================================== --}}

                            <button
                                type="submit"

                                class="
                                    login-button
                                    group
                                    relative
                                    w-full
                                    h-12
                                    rounded-xl
                                    text-white
                                    font-semibold
                                    text-sm
                                    shadow-lg
                                    shadow-brand-blue/20
                                    overflow-hidden
                                "
                            >


                                {{-- Shine Effect --}}

                                <span
                                    class="
                                        absolute
                                        inset-0
                                        -translate-x-full
                                        group-hover:translate-x-full
                                        transition-transform
                                        duration-700
                                        bg-gradient-to-r
                                        from-transparent
                                        via-white/20
                                        to-transparent
                                    "
                                ></span>


                                <span
                                    class="
                                        relative
                                        flex
                                        items-center
                                        justify-center
                                        gap-2
                                    "
                                >

                                    Masuk ke Dashboard


                                    <svg
                                        width="17"
                                        height="17"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="
                                            group-hover:translate-x-1
                                            transition-transform
                                        "
                                    >

                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>

                                        <polyline
                                            points="12 5 19 12 12 19"
                                        ></polyline>

                                    </svg>

                                </span>

                            </button>


                        </form>



                        {{-- =================================================
                             INFORMATION BOX
                        ================================================== --}}

                        <div
                            class="
                                mt-7
                                rounded-2xl
                                border
                                border-brand-blue/10
                                bg-gradient-to-br
                                from-brand-blue/[0.04]
                                via-brand-teal/[0.04]
                                to-brand-lime/[0.05]
                                p-4
                            "
                        >

                            <div
                                class="
                                    flex
                                    items-start
                                    gap-3
                                "
                            >


                                <div
                                    class="
                                        flex-shrink-0
                                        w-9
                                        h-9
                                        rounded-xl
                                        bg-brand-blue/10
                                        text-brand-blue
                                        flex
                                        items-center
                                        justify-center
                                    "
                                >

                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                        ></circle>

                                        <line
                                            x1="12"
                                            y1="16"
                                            x2="12"
                                            y2="12"
                                        ></line>

                                        <line
                                            x1="12"
                                            y1="8"
                                            x2="12.01"
                                            y2="8"
                                        ></line>

                                    </svg>

                                </div>


                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                            text-ink
                                        "
                                    >
                                        Akses khusus pegawai
                                    </p>


                                    <p
                                        class="
                                            text-[11px]
                                            text-slate-500
                                            leading-relaxed
                                            mt-1
                                        "
                                    >

                                        Gunakan NIPP dan password yang telah
                                        diberikan oleh administrator sistem.

                                    </p>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                             BACK LINK
                        ================================================== --}}

                        <div
                            class="
                                text-center
                                mt-7
                            "
                        >

                            <a
                                href="/"
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    text-xs
                                    text-slate-400
                                    hover:text-brand-blue
                                    transition
                                "
                            >

                                <svg
                                    width="15"
                                    height="15"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <line
                                        x1="19"
                                        y1="12"
                                        x2="5"
                                        y2="12"
                                    ></line>

                                    <polyline
                                        points="12 19 5 12 12 5"
                                    ></polyline>

                                </svg>

                                Kembali ke halaman pelanggan

                            </a>

                        </div>


                    </div>

                </section>


            </div>

        </div>

    </main>


</body>

</html>