<section id="alur" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
    <div class="max-w-xl mx-auto text-center">
        <p class="text-brand-teal font-semibold text-sm tracking-widest uppercase mb-3">Cara Mengadu</p>
        <h2 class="font-display font-bold text-2xl sm:text-3xl lg:text-4xl text-ink">Empat Langkah Sederhana</h2>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mt-10 sm:mt-14">
        @php
            $langkah = [
                ['no' => '01', 'judul' => 'Isi Form', 'desk' => 'Lengkapi informasi pengaduan.', 'warna' => 'bg-brand-blue shadow-brand-blue/30'],
                ['no' => '02', 'judul' => 'Kirim', 'desk' => 'Kirim pengaduan melalui sistem.', 'warna' => 'bg-brand-teal shadow-brand-teal/30'],
                ['no' => '03', 'judul' => 'Dapatkan Nomor', 'desk' => 'Simpan nomor pengaduan Anda.', 'warna' => 'bg-brand-green shadow-brand-green/30'],
                ['no' => '04', 'judul' => 'Pantau', 'desk' => 'Lacak perkembangan pengaduan.', 'warna' => 'bg-brand-lime shadow-brand-lime/30'],
            ];
        @endphp

        @foreach ($langkah as $item)
            <div class="flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-full {{ $item['warna'] }} text-white font-display font-bold flex items-center justify-center mb-4 text-sm shadow-lg">
                    {{ $item['no'] }}
                </div>
                <p class="font-display font-semibold text-ink text-sm sm:text-base">{{ $item['judul'] }}</p>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5">{{ $item['desk'] }}</p>
            </div>
        @endforeach
    </div>
</section>