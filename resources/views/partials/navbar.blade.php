<header x-data="{
        mobileOpen: false,
        activeSection: 'beranda',
        initScrollspy() {
            const sections = document.querySelectorAll('section[id]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) this.activeSection = entry.target.id;
                });
            }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
            sections.forEach(s => observer.observe(s));
        }
      }" x-init="initScrollspy()" class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-between h-16 sm:h-20">
        <a href="/#beranda" class="flex items-center gap-2 sm:gap-3">
            <img src="{{ asset('images/logo/logo-pdam.jpg') }}" alt="Logo PDAM Tirtanadi" class="w-9 h-9 sm:w-11 sm:h-11 rounded-full object-cover shrink-0 ring-1 ring-slate-100">
            <div class="leading-tight">
                <p class="font-display font-bold text-sm sm:text-lg tracking-tight">TIRTANADI</p>
                <p class="text-[10px] sm:text-xs text-slate-500 -mt-0.5">Sistem Pengaduan Pelanggan</p>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-9 font-medium text-sm">
            <a href="/#beranda" :class="activeSection === 'beranda' ? 'text-brand-blue font-semibold' : 'text-slate-500 hover:text-brand-blue'" class="transition">Beranda</a>
            <a href="/#layanan" :class="activeSection === 'layanan' ? 'text-brand-blue font-semibold' : 'text-slate-500 hover:text-brand-blue'" class="transition">Layanan</a>
            <a href="/#alur" :class="activeSection === 'alur' ? 'text-brand-blue font-semibold' : 'text-slate-500 hover:text-brand-blue'" class="transition">Alur Pengaduan</a>
            <a href="/#tentang" :class="activeSection === 'tentang' ? 'text-brand-blue font-semibold' : 'text-slate-500 hover:text-brand-blue'" class="transition">Tentang</a>
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="/lacak" class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-brand-teal border border-brand-teal/30 rounded-full px-5 py-2.5 hover:bg-brand-teal/5 transition">
                Lacak Pengaduan
            </a>
            <a href="/pengaduan/buat" class="hidden sm:inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-white bg-brand-blue rounded-full px-4 sm:px-5 py-2 sm:py-2.5 shadow-md shadow-brand-blue/30 hover:bg-brand-bluelight transition">
                Buat Pengaduan
            </a>

            <button @click="mobileOpen = !mobileOpen" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100" aria-label="Buka menu">
                <svg x-show="!mobileOpen" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-collapse @click.outside="mobileOpen = false" class="lg:hidden border-t border-slate-100 bg-white" style="display:none">
        <nav class="flex flex-col px-4 sm:px-6 py-4 gap-1 font-medium text-sm">
            <a href="/#beranda" @click="mobileOpen = false" :class="activeSection === 'beranda' ? 'text-brand-blue bg-brand-blue/5' : 'text-slate-600'" class="py-2.5 px-2 rounded-lg hover:bg-slate-50">Beranda</a>
            <a href="/#layanan" @click="mobileOpen = false" :class="activeSection === 'layanan' ? 'text-brand-blue bg-brand-blue/5' : 'text-slate-600'" class="py-2.5 px-2 rounded-lg hover:bg-slate-50">Layanan</a>
            <a href="/#alur" @click="mobileOpen = false" :class="activeSection === 'alur' ? 'text-brand-blue bg-brand-blue/5' : 'text-slate-600'" class="py-2.5 px-2 rounded-lg hover:bg-slate-50">Alur Pengaduan</a>
            <a href="/#tentang" @click="mobileOpen = false" :class="activeSection === 'tentang' ? 'text-brand-blue bg-brand-blue/5' : 'text-slate-600'" class="py-2.5 px-2 rounded-lg hover:bg-slate-50">Tentang</a>

            <div class="flex flex-col gap-2 mt-3 pt-3 border-t border-slate-100">
                <a href="/lacak" class="text-center text-sm font-semibold text-brand-teal border border-brand-teal/30 rounded-full px-5 py-2.5">
                    Lacak Pengaduan
                </a>
                <a href="/pengaduan/buat" class="text-center text-sm font-semibold text-white bg-brand-blue rounded-full px-5 py-2.5">
                    Buat Pengaduan
                </a>
            </div>
        </nav>
    </div>
</header>