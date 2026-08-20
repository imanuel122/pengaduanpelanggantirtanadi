<section id="beranda" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pt-10 sm:pt-16 pb-14 sm:pb-20 relative overflow-hidden">
    <div class="absolute -left-24 top-10 w-72 h-72 rounded-full bg-brand-lime/10 blur-2xl"></div>
    <div class="absolute right-0 bottom-0 w-96 h-96 rounded-full bg-brand-blue/5 blur-3xl"></div>

    <div class="grid lg:grid-cols-2 gap-10 sm:gap-14 items-center relative">
        <div>
            <span class="inline-flex items-center gap-2 bg-brand-teal/10 text-brand-teal text-xs font-semibold px-4 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-lime"></span>
                Layanan Pengaduan Pelanggan
            </span>
            <h1 class="font-display font-extrabold text-3xl sm:text-5xl text-ink mt-5 sm:mt-6 leading-[1.12] tracking-tight">
                Sampaikan Pengaduan,<br>
                <span class="text-brand-blue">Kami Tanggapi Cepat.</span>
            </h1>
            <p class="text-slate-600 text-base sm:text-lg mt-4 sm:mt-6 leading-relaxed max-w-lg">
                Laporkan gangguan air, kebocoran pipa, atau kendala meteran ke PDAM Tirtanadi
                Cabang Padang Bulan tanpa perlu akun. Pantau progres kapan saja lewat nomor pengaduan Anda.
            </p>
            <div class="flex flex-col xs:flex-row gap-3 sm:gap-4 mt-7 sm:mt-9">
                <a href="/pengaduan/buat" class="inline-flex items-center justify-center gap-2 bg-brand-blue text-white font-semibold rounded-xl px-6 py-3.5 shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition text-sm sm:text-base">
                    📝 Buat Pengaduan
                </a>
                <a href="/lacak" class="inline-flex items-center justify-center gap-2 border-2 border-brand-teal/30 text-brand-teal font-semibold rounded-xl px-6 py-3.5 hover:bg-brand-teal/5 transition text-sm sm:text-base">
                    🔍 Lacak Pengaduan
                </a>
            </div>

            {{-- Statistik: nanti isi dari Controller, contoh $totalPengaduan, $tingkatSelesai, $rataVerifikasi --}}
            <div class="grid grid-cols-3 gap-2 sm:gap-3 mt-9 pt-7 border-t border-slate-100">
                <div class="flex flex-col items-center text-center gap-1.5 sm:flex-row sm:items-center sm:text-left sm:gap-3 bg-brand-blue/5 rounded-xl sm:rounded-2xl px-2 py-3 sm:pl-2 sm:pr-4 sm:py-2">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-brand-blue flex items-center justify-center shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="sm:w-4 sm:h-4"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-sm sm:text-lg text-brand-blue leading-none">{{ $totalPengaduan ?? '1.240+' }}</p>
                        <p class="text-[9px] sm:text-[11px] text-slate-500 mt-1 leading-tight">Pengaduan Ditangani</p>
                    </div>
                </div>
                <div class="flex flex-col items-center text-center gap-1.5 sm:flex-row sm:items-center sm:text-left sm:gap-3 bg-brand-green/5 rounded-xl sm:rounded-2xl px-2 py-3 sm:pl-2 sm:pr-4 sm:py-2">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-brand-green flex items-center justify-center shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="sm:w-4 sm:h-4"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-sm sm:text-lg text-brand-green leading-none">{{ $tingkatSelesai ?? '94%' }}</p>
                        <p class="text-[9px] sm:text-[11px] text-slate-500 mt-1 leading-tight">Tingkat Selesai</p>
                    </div>
                </div>
                <div class="flex flex-col items-center text-center gap-1.5 sm:flex-row sm:items-center sm:text-left sm:gap-3 bg-brand-teal/5 rounded-xl sm:rounded-2xl px-2 py-3 sm:pl-2 sm:pr-4 sm:py-2">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-brand-teal flex items-center justify-center shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="sm:w-4 sm:h-4"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-sm sm:text-lg text-brand-teal leading-none">{{ $rataVerifikasi ?? '<24 Jam' }}</p>
                        <p class="text-[9px] sm:text-[11px] text-slate-500 mt-1 leading-tight">Rata Verifikasi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CAROUSEL FOTO KEGIATAN --}}
        {{-- Ganti src di bawah dengan foto asli. Taruh foto di public/images/kegiatan/, lalu src="/images/kegiatan/nama-file.jpg" --}}
        <div x-data="{
                active: 0,
                slides: [
                    { src: '/images/kegiatan/kegiatan-1.jpeg', caption: 'Kunjungan lapangan tim teknis Padang Bulan' },
                    { src: '/images/kegiatan/kegiatan-2.jpeg', caption: 'Perbaikan jaringan pipa distribusi' },
                    { src: '/images/kegiatan/kegiatan-3.jpeg', caption: 'Sosialisasi layanan ke warga sekitar' },
                    { src: '/images/kegiatan/kegiatan-5.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                    { src: '/images/kegiatan/kegiatan-6.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                    { src: '/images/kegiatan/kegiatan-7.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                    { src: '/images/kegiatan/kegiatan-8.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                    { src: '/images/kegiatan/kegiatan-9.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                    { src: '/images/kegiatan/kegiatan-10.jpeg', caption: 'Pemeliharaan rutin meteran pelanggan' },
                ],
                init() { setInterval(() => { this.active = (this.active + 1) % this.slides.length }, 4000) }
             }" x-init="init()" class="relative rounded-3xl overflow-hidden shadow-2xl shadow-brand-blue/20 aspect-[4/3.3] sm:aspect-[4/3.1] border-4 border-white ring-1 ring-slate-100">

            <template x-for="(slide, i) in slides" :key="i">
                <div x-show="active === i"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-200">
                    <img :src="slide.src" class="w-full h-full object-cover" onerror="this.style.display='none'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <p class="text-white font-display font-semibold text-sm sm:text-base" x-text="slide.caption"></p>
                    </div>
                </div>
            </template>

            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur rounded-lg px-3 py-1.5 text-[11px] font-semibold text-brand-teal flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-green animate-pulse"></span> PDAM Tirtanadi Cabang Padang Bulan
            </div>

            <div class="absolute bottom-5 right-5 flex gap-1.5">
                <template x-for="(slide, i) in slides" :key="i">
                    <button @click="active = i" :class="active === i ? 'w-6 bg-white' : 'w-1.5 bg-white/50'" class="h-1.5 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </div>
</section>