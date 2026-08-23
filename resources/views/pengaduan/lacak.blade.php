@extends('layouts.app')

@section('title', 'Lacak Pengaduan — PDAM Tirtanadi Padang Bulan')

@section('meta_description', 'Pantau perkembangan status pengaduan Anda menggunakan nomor pengaduan.')

@section('content')

{{-- =========================================================
     STYLE KHUSUS HALAMAN LACAK
========================================================= --}}
<style>
    [x-cloak] {
        display: none !important;
    }

    /* Mencegah gambar lightbox terseleksi */
    .lightbox-image {
        -webkit-user-drag: none;
        user-select: none;
    }

    /* Animasi zoom ringan saat gambar muncul */
    .lightbox-image {
        animation: lightboxZoom .2s ease-out;
    }

    @keyframes lightboxZoom {
        from {
            opacity: 0;
            transform: scale(.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>


<section
    class="
        max-w-3xl
        mx-auto
        px-4
        sm:px-6
        lg:px-10
        py-10
        sm:py-16
    "
>

    {{-- =========================================================
         BREADCRUMB
    ========================================================== --}}
    <div
        class="
            flex
            items-center
            gap-2
            text-xs
            sm:text-sm
            text-slate-400
            mb-6
        "
    >

        <a
            href="/"
            class="hover:text-brand-blue transition"
        >
            Beranda
        </a>

        <span>/</span>

        <span class="text-slate-600 font-medium">
            Lacak Pengaduan
        </span>

    </div>



    {{-- =========================================================
         HEADER HALAMAN
    ========================================================== --}}
    <div class="mb-8 sm:mb-10">

        <span
            class="
                inline-flex
                items-center
                gap-2
                bg-brand-teal/10
                text-brand-teal
                text-xs
                font-semibold
                px-4
                py-1.5
                rounded-full
            "
        >

            <span
                class="
                    w-1.5
                    h-1.5
                    rounded-full
                    bg-brand-lime
                "
            ></span>

            Pantau Status Pengaduan

        </span>


        <h1
            class="
                font-display
                font-extrabold
                text-2xl
                sm:text-4xl
                text-ink
                mt-4
                leading-tight
            "
        >
            Lacak Pengaduan Anda
        </h1>


        <p
            class="
                text-slate-600
                mt-2
                text-sm
                sm:text-base
                max-w-xl
            "
        >
            Masukkan nomor pengaduan yang Anda terima saat mengirim laporan
            untuk melihat perkembangan penanganannya.
        </p>

    </div>



    {{-- =========================================================
         FORM PENCARIAN
    ========================================================== --}}
    <form
        method="GET"
        action="/lacak"

        class="
            bg-white
            rounded-2xl
            border
            border-slate-100
            shadow-sm
            p-4
            sm:p-5

            flex
            flex-col
            sm:flex-row

            gap-3
        "
    >

        <input
            type="text"
            name="kode"
            value="{{ $kodeDicari }}"

            placeholder="Contoh: PGD-20260818-00001"

            class="
                flex-1
                h-12
                rounded-xl
                border
                border-slate-200
                px-4
                text-sm

                focus:ring-2
                focus:ring-brand-blue
                focus:border-brand-blue

                outline-none
                transition

                uppercase
                placeholder:normal-case
            "
        >


        <button
            type="submit"

            class="
                inline-flex
                items-center
                justify-center
                gap-2

                bg-brand-blue
                text-white

                font-semibold

                rounded-xl

                px-6
                py-3

                shadow-lg
                shadow-brand-blue/30

                hover:bg-brand-bluelight

                transition

                text-sm
            "
        >

            <svg
                width="17"
                height="17"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >

                <circle
                    cx="11"
                    cy="11"
                    r="7"
                ></circle>

                <path
                    d="m20 20-4-4"
                ></path>

            </svg>

            Lacak

        </button>

    </form>



    {{-- =========================================================
         STATE 1
         BELUM MENCARI
    ========================================================== --}}
    @if (!$sudahDicari)

        <div
            class="
                text-center
                py-16
                sm:py-20
            "
        >

            <div
                class="
                    w-16
                    h-16
                    sm:w-20
                    sm:h-20

                    rounded-full

                    bg-brand-blue/10

                    flex
                    items-center
                    justify-center

                    mx-auto
                    mb-5
                "
            >

                <svg
                    width="30"
                    height="30"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#0B6FB4"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    ></circle>

                    <path
                        d="M21 21l-4.35-4.35"
                    ></path>

                </svg>

            </div>


            <p
                class="
                    font-display
                    font-semibold
                    text-ink
                "
            >
                Masukkan nomor pengaduan Anda
            </p>


            <p
                class="
                    text-sm
                    text-slate-500
                    mt-1
                    max-w-sm
                    mx-auto
                "
            >
                Nomor pengaduan bisa Anda temukan di halaman sukses setelah
                mengirim laporan, atau di surat pengaduan yang sudah dicetak.
            </p>

        </div>



    {{-- =========================================================
         STATE 2
         PENGADUAN TIDAK DITEMUKAN
    ========================================================== --}}
    @elseif (!$pengaduan)

        <div
            class="
                text-center
                py-16
                sm:py-20
            "
        >

            <div
                class="
                    w-16
                    h-16
                    sm:w-20
                    sm:h-20

                    rounded-full

                    bg-red-50

                    flex
                    items-center
                    justify-center

                    mx-auto
                    mb-5
                "
            >

                <svg
                    width="30"
                    height="30"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#EF4444"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="10"
                    ></circle>

                    <path
                        d="M12 8v4"
                    ></path>

                    <path
                        d="M12 16h.01"
                    ></path>

                </svg>

            </div>


            <p
                class="
                    font-display
                    font-semibold
                    text-ink
                "
            >
                Pengaduan tidak ditemukan
            </p>


            <p
                class="
                    text-sm
                    text-slate-500
                    mt-1
                    max-w-sm
                    mx-auto
                "
            >

                Nomor pengaduan

                <span class="font-semibold text-ink">
                    {{ $kodeDicari }}
                </span>

                tidak terdaftar di sistem kami.

                Periksa kembali penulisannya, pastikan formatnya seperti

                <span class="font-mono">
                    PGD-20260818-00001
                </span>.

            </p>

        </div>



    {{-- =========================================================
         STATE 3
         PENGADUAN DITEMUKAN
    ========================================================== --}}
    @else

        <div
            class="
                mt-8
                space-y-6
            "

            x-data="{
                lightboxUrl: null,

                openLightbox(url) {
                    this.lightboxUrl = url;
                    document.body.style.overflow = 'hidden';
                },

                closeLightbox() {
                    this.lightboxUrl = null;
                    document.body.style.overflow = '';
                }
            }"

            x-init="
                $watch('lightboxUrl', value => {
                    if (!value) {
                        document.body.style.overflow = '';
                    }
                })
            "
        >


            {{-- =====================================================
                 RINGKASAN PENGADUAN
            ====================================================== --}}
            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-100
                    shadow-sm
                    p-5
                    sm:p-7
                "
            >

                <div
                    class="
                        flex
                        flex-wrap
                        items-start
                        justify-between
                        gap-3
                    "
                >

                    <div>

                        <p
                            class="
                                text-xs
                                text-slate-400
                            "
                        >
                            Nomor Pengaduan
                        </p>


                        <p
                            class="
                                font-display
                                font-bold
                                text-lg
                                sm:text-xl
                                text-brand-blue
                                tracking-wide
                            "
                        >
                            {{ $pengaduan->kode_pengaduan }}
                        </p>

                    </div>


                    <span
                        class="
                            inline-flex
                            items-center
                            px-3
                            py-1.5
                            rounded-full
                            text-xs
                            font-semibold
                            {{ $pengaduan->statusColor() }}
                        "
                    >
                        {{ $pengaduan->statusLabel() }}
                    </span>

                </div>



                {{-- =================================================
                     DETAIL PENGADUAN
                ================================================== --}}
                <div
                    class="
                        grid
                        sm:grid-cols-2
                        gap-x-4
                        gap-y-3

                        mt-5
                        pt-5

                        border-t
                        border-slate-100

                        text-sm
                    "
                >

                    {{-- Kategori --}}
                    <div>

                        <p class="text-xs text-slate-400">
                            Kategori
                        </p>

                        <p
                            class="
                                text-ink
                                font-medium
                                mt-0.5
                            "
                        >
                            {{ $pengaduan->kategori->nama ?? '-' }}
                        </p>

                    </div>


                    {{-- Tanggal --}}
                    <div>

                        <p class="text-xs text-slate-400">
                            Tanggal Dibuat
                        </p>

                        <p
                            class="
                                text-ink
                                font-medium
                                mt-0.5
                            "
                        >
                            {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }}
                            WIB
                        </p>

                    </div>


                    {{-- Judul --}}
                    <div class="sm:col-span-2">

                        <p class="text-xs text-slate-400">
                            Judul
                        </p>

                        <p
                            class="
                                text-ink
                                font-medium
                                mt-0.5
                                break-words
                            "
                        >
                            {{ $pengaduan->judul }}
                        </p>

                    </div>


                    {{-- Deskripsi --}}
                    <div class="sm:col-span-2">

                        <p class="text-xs text-slate-400">
                            Deskripsi
                        </p>

                        <p
                            class="
                                text-ink
                                mt-0.5
                                leading-relaxed
                                break-words
                            "
                        >
                            {{ $pengaduan->deskripsi }}
                        </p>

                    </div>


                    {{-- Petugas --}}
                    @if ($pengaduan->petugas)

                        <div>

                            <p class="text-xs text-slate-400">
                                Ditangani Oleh
                            </p>

                            <p
                                class="
                                    text-ink
                                    font-medium
                                    mt-0.5
                                "
                            >
                                {{ $pengaduan->petugas->name }}
                            </p>

                        </div>

                    @endif

                </div>



                {{-- =================================================
                     FOTO BUKTI PELAPOR
                ================================================== --}}
                @if ($pengaduan->fotos->count() > 0)

                    <div
                        class="
                            mt-5
                            pt-5
                            border-t
                            border-slate-100
                        "
                    >

                        <p
                            class="
                                text-xs
                                text-slate-400
                                mb-3
                            "
                        >
                            Foto Bukti dari Pelapor
                        </p>


                        <div
                            class="
                                grid
                                grid-cols-4
                                sm:grid-cols-6
                                gap-2
                            "
                        >

                            @foreach ($pengaduan->fotos as $foto)

                                <button
                                    type="button"

                                    @click="openLightbox(@js($foto->url()))"

                                    class="
                                        group
                                        relative

                                        block
                                        w-full
                                        h-16
                                        sm:h-20

                                        rounded-lg
                                        overflow-hidden

                                        border
                                        border-slate-200

                                        bg-slate-100

                                        cursor-zoom-in

                                        focus:outline-none
                                        focus:ring-2
                                        focus:ring-brand-blue
                                        focus:ring-offset-2
                                    "
                                >

                                    <img
                                        src="{{ $foto->url() }}"

                                        alt="Foto bukti pengaduan"

                                        loading="lazy"

                                        class="
                                            w-full
                                            h-full
                                            object-cover

                                            transition
                                            duration-300

                                            group-hover:scale-105
                                            group-hover:opacity-80
                                        "
                                    >


                                    {{-- Overlay zoom --}}
                                    <span
                                        class="
                                            absolute
                                            inset-0

                                            flex
                                            items-center
                                            justify-center

                                            bg-black/0
                                            group-hover:bg-black/20

                                            transition
                                        "
                                    >

                                        <svg
                                            width="19"
                                            height="19"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="white"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"

                                            class="
                                                opacity-0
                                                group-hover:opacity-100
                                                transition
                                                drop-shadow-lg
                                            "
                                        >

                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="7"
                                            ></circle>

                                            <path
                                                d="m20 20-4-4"
                                            ></path>

                                            <path
                                                d="M11 8v6"
                                            ></path>

                                            <path
                                                d="M8 11h6"
                                            ></path>

                                        </svg>

                                    </span>

                                </button>

                            @endforeach

                        </div>

                    </div>

                @endif



                {{-- =================================================
                     CETAK SURAT
                ================================================== --}}
                <a
                    href="/pengaduan/{{ $pengaduan->kode_pengaduan }}/surat"

                    class="
                        inline-flex
                        items-center
                        gap-2

                        mt-6

                        text-sm
                        font-semibold

                        text-brand-teal

                        border
                        border-brand-teal/30

                        rounded-full

                        px-5
                        py-2.5

                        hover:bg-brand-teal/5

                        transition
                    "
                >

                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path
                            d="M6 9V2h12v7"
                        ></path>

                        <path
                            d="
                                M6 18H4
                                a2 2 0 0 1-2-2v-5
                                a2 2 0 0 1 2-2h16
                                a2 2 0 0 1 2 2v5
                                a2 2 0 0 1-2 2h-2
                            "
                        ></path>

                        <path
                            d="M6 14h12v8H6z"
                        ></path>

                    </svg>

                    Lihat / Cetak Surat Pengaduan

                </a>

            </div>



            {{-- =====================================================
                 TIMELINE
            ====================================================== --}}
            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-100
                    shadow-sm
                    p-5
                    sm:p-7
                "
            >

                <p
                    class="
                        font-display
                        font-semibold
                        text-ink
                        mb-6
                    "
                >
                    Riwayat Perkembangan
                </p>


                <div class="space-y-0">

                    @foreach ($pengaduan->tanggapans as $tanggapan)

                        <div
                            class="
                                flex
                                gap-4
                            "
                        >

                            {{-- =================================================
                                 TITIK & GARIS
                            ================================================== --}}
                            <div
                                class="
                                    flex
                                    flex-col
                                    items-center
                                "
                            >

                                <span
                                    class="
                                        w-3.5
                                        h-3.5
                                        rounded-full

                                        {{ $tanggapan->dotColorClass() }}

                                        ring-4
                                        ring-white

                                        shrink-0

                                        mt-1
                                    "
                                ></span>


                                @if (!$loop->last)

                                    <span
                                        class="
                                            w-0.5
                                            flex-1
                                            bg-slate-100
                                            my-1
                                        "
                                    ></span>

                                @endif

                            </div>



                            {{-- =================================================
                                 KONTEN TIMELINE
                            ================================================== --}}
                            <div
                                class="
                                    pb-6
                                    flex-1
                                    min-w-0
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        text-slate-400
                                    "
                                >
                                    {{ $tanggapan->created_at->translatedFormat('d F Y, H:i') }}
                                    WIB
                                </p>


                                <p
                                    class="
                                        text-sm
                                        text-ink
                                        mt-1
                                        leading-relaxed
                                        break-words
                                    "
                                >
                                    {{ $tanggapan->pesan }}
                                </p>


                                @if ($tanggapan->user)

                                    <p
                                        class="
                                            text-xs
                                            text-slate-400
                                            mt-1
                                        "
                                    >
                                        oleh {{ $tanggapan->user->name }}
                                    </p>

                                @endif



                                {{-- =================================================
                                     FOTO TANGGAPAN
                                ================================================== --}}
                                @if ($tanggapan->fotos->count() > 0)

                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            gap-2
                                            mt-3
                                        "
                                    >

                                        @foreach ($tanggapan->fotos as $foto)

                                            <button
                                                type="button"

                                                @click="openLightbox(@js($foto->url()))"

                                                class="
                                                    group
                                                    relative

                                                    block

                                                    h-20
                                                    w-20

                                                    rounded-lg
                                                    overflow-hidden

                                                    border
                                                    border-slate-200

                                                    bg-slate-100

                                                    cursor-zoom-in

                                                    focus:outline-none
                                                    focus:ring-2
                                                    focus:ring-brand-blue
                                                    focus:ring-offset-2
                                                "
                                            >

                                                <img
                                                    src="{{ $foto->url() }}"

                                                    alt="Foto tanggapan"

                                                    loading="lazy"

                                                    class="
                                                        h-full
                                                        w-full
                                                        object-cover

                                                        transition
                                                        duration-300

                                                        group-hover:scale-105
                                                        group-hover:opacity-80
                                                    "
                                                >


                                                {{-- Overlay zoom --}}
                                                <span
                                                    class="
                                                        absolute
                                                        inset-0

                                                        flex
                                                        items-center
                                                        justify-center

                                                        bg-black/0
                                                        group-hover:bg-black/20

                                                        transition
                                                    "
                                                >

                                                    <svg
                                                        width="18"
                                                        height="18"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="white"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"

                                                        class="
                                                            opacity-0
                                                            group-hover:opacity-100
                                                            transition
                                                            drop-shadow-lg
                                                        "
                                                    >

                                                        <circle
                                                            cx="11"
                                                            cy="11"
                                                            r="7"
                                                        ></circle>

                                                        <path
                                                            d="m20 20-4-4"
                                                        ></path>

                                                        <path
                                                            d="M11 8v6"
                                                        ></path>

                                                        <path
                                                            d="M8 11h6"
                                                        ></path>

                                                    </svg>

                                                </span>

                                            </button>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>



            {{-- =====================================================
                 LACAK PENGADUAN LAIN
            ====================================================== --}}
            <div class="text-center">

                <a
                    href="/lacak"

                    class="
                        inline-flex
                        items-center
                        gap-2

                        text-sm
                        font-semibold

                        text-slate-500

                        hover:text-brand-blue

                        transition
                    "
                >

                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path
                            d="M3 12a9 9 0 1 0 3-6.7"
                        ></path>

                        <polyline
                            points="3 4 3 10 9 10"
                        ></polyline>

                    </svg>

                    Lacak pengaduan lain

                </a>

            </div>



            {{-- =====================================================
                 LIGHTBOX
                 DIPINDAHKAN LANGSUNG KE BODY
            ====================================================== --}}
            <template x-teleport="body">

                <div
                    x-show="lightboxUrl"

                    x-cloak

                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"

                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"

                    @keydown.escape.window="closeLightbox()"

                    class="
                        fixed
                        inset-0

                        w-screen
                        h-screen
                        h-[100dvh]

                        z-[999999]

                        bg-slate-950/95

                        flex
                        items-center
                        justify-center

                        overflow-hidden

                        p-2
                        sm:p-4
                        lg:p-5
                    "

                    role="dialog"
                    aria-modal="true"
                    aria-label="Pratinjau gambar"
                >


                    {{-- =================================================
                         BACKDROP
                    ================================================== --}}
                    <button
                        type="button"

                        @click="closeLightbox()"

                        class="
                            absolute
                            inset-0

                            w-full
                            h-full

                            cursor-zoom-out

                            focus:outline-none
                        "

                        aria-label="Tutup pratinjau"
                    ></button>



                    {{-- =================================================
                         TOMBOL CLOSE
                    ================================================== --}}
                    <button
                        type="button"

                        @click="closeLightbox()"

                        class="
                            fixed

                            top-3
                            right-3

                            sm:top-5
                            sm:right-5

                            lg:top-6
                            lg:right-6

                            z-[1000000]

                            w-11
                            h-11

                            sm:w-12
                            sm:h-12

                            rounded-full

                            flex
                            items-center
                            justify-center

                            bg-black/50
                            hover:bg-white/20
                            active:bg-white/30

                            border
                            border-white/20

                            text-white

                            shadow-xl

                            backdrop-blur-md

                            transition

                            focus:outline-none
                            focus:ring-2
                            focus:ring-white/50
                        "

                        aria-label="Tutup gambar"
                    >

                        <svg
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        >

                            <path
                                d="M6 6L18 18"
                            ></path>

                            <path
                                d="M18 6L6 18"
                            ></path>

                        </svg>

                    </button>



                    {{-- =================================================
                         IMAGE WRAPPER
                    ================================================== --}}
                    <div
                        class="
                            relative

                            z-[999999]

                            w-full
                            h-full

                            flex
                            items-center
                            justify-center

                            pointer-events-none
                        "
                    >


                        {{-- =================================================
                             GAMBAR FULL
                        ================================================== --}}
                        <img
                            :src="lightboxUrl"

                            @click.stop

                            alt="Foto pengaduan ukuran penuh"

                            class="
                                lightbox-image

                                pointer-events-auto

                                block

                                w-auto
                                h-auto

                                max-w-[96vw]
                                max-h-[94dvh]

                                object-contain

                                rounded-md
                                sm:rounded-lg

                                shadow-[0_20px_80px_rgba(0,0,0,0.55)]

                                select-none

                                transition
                                duration-200
                            "
                        >

                    </div>



                    {{-- =================================================
                         PETUNJUK BAWAH
                    ================================================== --}}
                    <div
                        class="
                            fixed

                            bottom-3
                            left-1/2

                            -translate-x-1/2

                            sm:bottom-5

                            z-[1000000]

                            px-4
                            py-2

                            rounded-full

                            bg-black/50
                            backdrop-blur-md

                            border
                            border-white/10

                            text-[10px]
                            sm:text-xs

                            text-white/70

                            whitespace-nowrap

                            pointer-events-none
                        "
                    >

                        Klik di luar gambar atau tekan ESC untuk menutup

                    </div>


                </div>

            </template>


        </div>

    @endif

</section>

@endsection