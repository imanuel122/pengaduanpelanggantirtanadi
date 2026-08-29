<footer class="bg-ink text-white/70">
    <div class="wave-divider"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">

            {{-- Kolom 1: Brand & deskripsi singkat --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo/logo-pdam.jpg') }}" alt="Logo PDAM Tirtanadi" class="w-11 h-11 rounded-full object-cover ring-2 ring-white/10 shrink-0">
                    <div>
                        <p class="font-display font-bold text-white text-sm tracking-tight">PDAM TIRTANADI</p>
                        <p class="text-xs text-white/40">Cabang Padang Bulan</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed max-w-xs">
                    Sistem pengaduan pelanggan untuk layanan air bersih PDAM Tirtanadi
                    Cabang Padang Bulan, Medan. Laporkan keluhan Anda kapan saja dan
                    pantau progres penanganannya secara transparan.
                </p>
            </div>

            {{-- Kolom 2: Tautan cepat --}}
            <div>
                <p class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wide">Tautan Cepat</p>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="/#beranda" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="/#layanan" class="hover:text-white transition">Layanan</a></li>
                    <li><a href="/#tentang" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="/#alur" class="hover:text-white transition">Alur Pengaduan</a></li>
                    <li><a href="/pengaduan/buat" class="hover:text-white transition">Buat Pengaduan</a></li>
                    <li><a href="/lacak" class="hover:text-white transition">Lacak Pengaduan</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Kontak --}}
            <div>
                <p class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wide">Kontak Kami</p>
                <ul class="space-y-3.5 text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0 mt-0.5 text-brand-bluelight">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Jl. Jamin Ginting KM 9 No. 88, Mangga, Kec. Medan Tuntungan, Kota Medan, Sumatera Utara 20131</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0 text-brand-bluelight">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                        <a href="tel:+6261836043" class="hover:text-white transition">(061) 8360432</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0 text-brand-bluelight">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        <span>Senin&ndash;Jumat, 08.00&ndash;16.00 WIB</span>
                    </li>
                </ul>
            </div>

            {{-- Kolom 4: Peta lokasi --}}
            <div>
                <p class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wide">Lokasi Kami</p>
                <div class="rounded-xl overflow-hidden border border-white/10 h-40 bg-white/5">
                    <iframe
                        src="https://www.google.com/maps?q=Kantor+PDAM+Tirtanadi+Cab+Padang+Bulan+Jl+Jamin+Ginting+KM+9+No+88+Mangga+Medan+Tuntungan&output=embed"
                        width="100%" height="100%" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi PDAM Tirtanadi Cabang Padang Bulan"></iframe>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=Kantor+PDAM+Tirtanadi+Cab+Padang+Bulan+Jl+Jamin+Ginting+KM+9+No+88+Mangga+Medan+Tuntungan"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1 text-xs font-semibold text-brand-bluelight hover:underline mt-2.5">
                    Buka di Google Maps ↗
                </a>
            </div>

        </div>

        {{-- Baris bawah --}}
        <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <p class="text-xs text-white/40">&copy; {{ date('Y') }} PDAM Tirtanadi Cabang Padang Bulan. All rights reserved.</p>
            <p class="text-xs text-white/30 italic">
                Dibuat oleh Imanuel Reformata Hulu untuk keperluan tugas/project, bukan situs resmi PDAM Tirtanadi.
            </p>
        </div>
    </div>
</footer>
