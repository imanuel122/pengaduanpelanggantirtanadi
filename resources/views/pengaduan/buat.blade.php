@extends('layouts.app')

@section('title', 'Buat Pengaduan — PDAM Tirtanadi Padang Bulan')
@section('meta_description', 'Sampaikan keluhan layanan air Anda ke PDAM Tirtanadi Cabang Padang Bulan tanpa perlu akun.')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-16">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-400 mb-6">
        <a href="/" class="hover:text-brand-blue transition">Beranda</a>
        <span>/</span>
        <span class="text-slate-600 font-medium">Buat Pengaduan</span>
    </div>

    {{-- Header halaman --}}
    <div class="mb-8 sm:mb-10">
        <span class="inline-flex items-center gap-2 bg-brand-blue/10 text-brand-blue text-xs font-semibold px-4 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-brand-lime"></span> Form Pengaduan Pelanggan
        </span>
        <h1 class="font-display font-extrabold text-2xl sm:text-4xl text-ink mt-4 leading-tight">
            Ceritakan Keluhan Anda
        </h1>
        <p class="text-slate-600 mt-2 text-sm sm:text-base max-w-xl">
            Isi form berikut dengan lengkap. Prosesnya cuma 4 langkah singkat, dan Anda akan
            mendapat nomor pengaduan begitu selesai — tidak perlu bikin akun.
        </p>
    </div>

    @if (session('success'))
        {{-- STATE SUKSES --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 sm:p-12 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-brand-green/10 flex items-center justify-center mx-auto mb-6">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#3FA75B" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <h2 class="font-display font-bold text-xl sm:text-2xl text-ink">Pengaduan Berhasil Dikirim!</h2>
            <p class="text-slate-500 mt-2 text-sm sm:text-base">Simpan nomor pengaduan Anda untuk memantau perkembangannya.</p>

            <div class="mt-6 inline-flex flex-col items-center bg-brand-blue/5 rounded-2xl px-6 sm:px-10 py-5 sm:py-6">
                <p class="text-xs text-slate-500">Nomor Pengaduan Anda</p>
                <p class="font-display font-bold text-xl sm:text-2xl text-brand-blue tracking-wide mt-1">{{ session('success') }}</p>
            </div>

            <a href="/pengaduan/{{ session('success') }}/surat" class="inline-flex items-center justify-center gap-2 bg-brand-teal text-white font-semibold rounded-xl px-6 py-3 shadow-lg shadow-brand-teal/30 hover:opacity-90 transition text-sm mt-6">
                🖨️ Cetak Surat Pengaduan (PDF)
            </a>

            <div class="flex flex-col xs:flex-row justify-center gap-3 mt-4">
                <a href="/lacak" class="inline-flex items-center justify-center gap-2 bg-brand-blue text-white font-semibold rounded-xl px-6 py-3 shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition text-sm">
                    🔍 Lacak Pengaduan Ini
                </a>
                <a href="/pengaduan/buat" class="inline-flex items-center justify-center gap-2 border-2 border-slate-200 text-ink font-semibold rounded-xl px-6 py-3 hover:border-brand-blue hover:text-brand-blue transition text-sm">
                    Buat Pengaduan Lain
                </a>
            </div>
        </div>
    @else
        {{-- FORM MULTI-STEP --}}
        <div id="form-pengaduan" x-data="pengaduanForm()">

            {{-- Ringkasan error server (tetap dipertahankan sebagai fallback) --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 mb-6 text-sm">
                    <p class="font-semibold mb-1">Ada beberapa isian yang perlu diperbaiki:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Step Indicator - Desktop --}}
            @php $stepLabels = ['Data Diri', 'Detail Pengaduan', 'Lokasi & Foto', 'Review & Kirim']; @endphp
            <div class="hidden sm:flex items-start mb-10">
                @foreach ($stepLabels as $i => $label)
                    @php $stepNum = $i + 1; @endphp
                    <div class="flex items-center {{ $i < count($stepLabels) - 1 ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-display font-bold text-sm transition-all duration-300"
                                 :class="currentStep > {{ $stepNum }} ? 'bg-brand-green text-white' : (currentStep === {{ $stepNum }} ? 'bg-brand-blue text-white ring-4 ring-brand-blue/20' : 'bg-slate-100 text-slate-400')">
                                <span x-show="currentStep <= {{ $stepNum }}">{{ $stepNum }}</span>
                                <svg x-show="currentStep > {{ $stepNum }}" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" style="display:none"><path d="M20 6L9 17l-5-5"/></svg>
                            </div>
                            <p class="text-xs font-medium mt-2 text-center whitespace-nowrap" :class="currentStep === {{ $stepNum }} ? 'text-brand-blue' : 'text-slate-400'">{{ $label }}</p>
                        </div>
                        @if ($i < count($stepLabels) - 1)
                            <div class="flex-1 h-0.5 mx-2 mb-6 transition-colors duration-300" :class="currentStep > {{ $stepNum }} ? 'bg-brand-green' : 'bg-slate-100'"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Step Indicator - Mobile --}}
            <div class="sm:hidden mb-6">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-semibold text-slate-500">Langkah <span x-text="currentStep"></span> dari 4</p>
                    <p class="text-xs font-semibold text-brand-blue">{{ $stepLabels[0] ?? '' }}</p>
                </div>
                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-brand-blue transition-all duration-300" :style="`width: ${(currentStep/4)*100}%`"></div>
                </div>
            </div>

            <form method="POST" action="/pengaduan" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-8 lg:p-10" @submit="submitForm($event)">
                @csrf

                {{-- ===== STEP 1: DATA DIRI ===== --}}
                <div data-step="1" x-show="currentStep === 1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-brand-blue flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-ink">Data Diri Pelapor</p>
                            <p class="text-xs text-slate-500">Supaya petugas bisa menghubungi Anda kembali</p>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-ink mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pelapor" x-model="form.nama_pelapor" maxlength="255"
                                   @blur="touched.nama_pelapor = true; validateField('nama_pelapor')"
                                   placeholder="Contoh: Budi Santoso"
                                   :class="touched.nama_pelapor && errors.nama_pelapor ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                   class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2">
                            <p x-show="touched.nama_pelapor && errors.nama_pelapor" x-text="errors.nama_pelapor" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="tel" name="no_hp" x-model="form.no_hp" maxlength="20"
                                   @blur="touched.no_hp = true; validateField('no_hp')"
                                   placeholder="08xxxxxxxxxx"
                                   :class="touched.no_hp && errors.no_hp ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                   class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2">
                            <p x-show="touched.no_hp && errors.no_hp" x-text="errors.no_hp" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">
                                Nomor Pelanggan (NPA)
                                <span class="text-slate-400 font-normal text-xs">— opsional</span>
                            </label>
                            <input type="text" name="no_pelanggan" x-model="form.no_pelanggan" maxlength="50"
                                   @blur="touched.no_pelanggan = true; validateField('no_pelanggan')"
                                   placeholder="Jika Anda pelanggan terdaftar"
                                   :class="touched.no_pelanggan && errors.no_pelanggan ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                   class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2">
                            <p x-show="touched.no_pelanggan && errors.no_pelanggan" x-text="errors.no_pelanggan" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-ink mb-1.5">
                                Email <span class="text-slate-400 font-normal text-xs">— opsional</span>
                            </label>
                            <input type="email" name="email" x-model="form.email" maxlength="255"
                                   @blur="touched.email = true; validateField('email')"
                                   placeholder="nama@email.com"
                                   :class="touched.email && errors.email ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                   class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2">
                            <p x-show="touched.email && errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-ink mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" x-model="form.alamat" rows="3"
                                      @blur="touched.alamat = true; validateField('alamat')"
                                      placeholder="Jalan, nomor rumah, kelurahan, kecamatan"
                                      :class="touched.alamat && errors.alamat ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                      class="w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2 resize-none"></textarea>
                            <p x-show="touched.alamat && errors.alamat" x-text="errors.alamat" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-ink mb-1.5">
                                Patokan Rumah <span class="text-slate-400 font-normal text-xs">— opsional</span>
                            </label>
                            <input type="text" name="no_rumah_patokan" x-model="form.no_rumah_patokan" maxlength="255"
                                   placeholder="Contoh: seberang minimarket, dekat gapura RT 5"
                                   class="w-full h-12 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                            <p class="text-xs text-slate-400 mt-1.5">Memudahkan petugas menemukan lokasi Anda.</p>
                        </div>
                    </div>
                </div>

                {{-- ===== STEP 2: DETAIL PENGADUAN ===== --}}
                <div data-step="2" x-show="currentStep === 2" style="display:none">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-brand-teal flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-ink">Detail Pengaduan</p>
                            <p class="text-xs text-slate-500">Jelaskan masalah yang Anda alami</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:gap-5">
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Kategori Pengaduan <span class="text-red-500">*</span></label>
                            <select name="kategori_pengaduan_id" x-model="form.kategori_pengaduan_id"
                                    @change="touched.kategori_pengaduan_id = true; categoryLabel = $event.target.selectedOptions[0].text; validateField('kategori_pengaduan_id')"
                                    :class="touched.kategori_pengaduan_id && errors.kategori_pengaduan_id ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                    class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2 bg-white">
                                <option value="" disabled>Pilih kategori keluhan Anda</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" @selected(old('kategori_pengaduan_id') == $kategori->id)>{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                            <p x-show="touched.kategori_pengaduan_id && errors.kategori_pengaduan_id" x-text="errors.kategori_pengaduan_id" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Judul Pengaduan <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" x-model="form.judul" maxlength="255"
                                   @blur="touched.judul = true; validateField('judul')"
                                   placeholder="Ringkasan singkat, contoh: Pipa bocor di depan rumah"
                                   :class="touched.judul && errors.judul ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                   class="w-full h-12 rounded-xl border px-4 text-sm outline-none transition focus:ring-2">
                            <p x-show="touched.judul && errors.judul" x-text="errors.judul" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" x-model="form.deskripsi" rows="5"
                                      @blur="touched.deskripsi = true; validateField('deskripsi')"
                                      placeholder="Ceritakan detail masalahnya: sejak kapan, seberapa parah, dan hal lain yang perlu petugas ketahui (minimal 20 karakter)"
                                      :class="touched.deskripsi && errors.deskripsi ? 'border-red-400 focus:ring-red-400 focus:border-red-400' : 'border-slate-200 focus:ring-brand-blue focus:border-brand-blue'"
                                      class="w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2 resize-none"></textarea>
                            <p x-show="touched.deskripsi && errors.deskripsi" x-text="errors.deskripsi" class="text-red-500 text-xs mt-1.5" style="display:none"></p>
                            <p x-show="!(touched.deskripsi && errors.deskripsi)" class="text-xs text-slate-400 mt-1.5">Semakin detail, semakin cepat petugas memahami masalah Anda.</p>
                        </div>
                    </div>
                </div>

                {{-- ===== STEP 3: LOKASI & FOTO ===== --}}
                <div data-step="3" x-show="currentStep === 3" style="display:none">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-brand-green flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-ink">Lokasi & Foto Bukti</p>
                            <p class="text-xs text-slate-500">Opsional, tapi sangat membantu petugas</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:gap-5">
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">
                                Detail Lokasi Kejadian <span class="text-slate-400 font-normal text-xs">— opsional</span>
                            </label>
                            <textarea name="lokasi_kejadian" x-model="form.lokasi_kejadian" rows="3"
                                      placeholder="Isi jika lokasi kejadian berbeda dari alamat rumah Anda"
                                      class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1.5">
                                Foto Bukti <span class="text-slate-400 font-normal text-xs">— opsional</span>
                            </label>

                            <div class="border-2 border-dashed rounded-2xl p-6 sm:p-8 text-center transition-colors"
                                 :class="errors.foto ? 'border-red-300 bg-red-50' : (dragging ? 'border-brand-blue bg-brand-blue/5' : 'border-slate-200')"
                                 @dragover.prevent="dragging = true"
                                 @dragleave.prevent="dragging = false"
                                 @drop.prevent="dragging = false;
                                                $refs.fotoInput.files = $event.dataTransfer.files;
                                                handleFoto($event.dataTransfer.files[0])">

                                <template x-if="!fotoPreview">
                                    <div>
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5" class="mx-auto mb-3"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
                                        <p class="text-sm text-slate-500">Tarik & lepas foto di sini, atau</p>
                                        <button type="button" @click="$refs.fotoInput.click()"
                                                class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-brand-blue border border-brand-blue/30 rounded-full px-5 py-2 hover:bg-brand-blue/5 transition">
                                            Pilih File
                                        </button>
                                        <p class="text-xs text-slate-400 mt-3">JPG, JPEG, atau PNG — maksimal 5MB</p>
                                    </div>
                                </template>

                                <template x-if="fotoPreview">
                                    <div class="relative inline-block">
                                        <img :src="fotoPreview" class="max-h-48 rounded-xl mx-auto shadow-sm">
                                        <button type="button"
                                                @click="fotoPreview = null; fotoName = ''; $refs.fotoInput.value = ''; delete errors.foto"
                                                class="absolute -top-2.5 -right-2.5 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center text-xs shadow-md hover:bg-red-600 transition">
                                            ✕
                                        </button>
                                        <p class="text-xs text-slate-400 mt-2" x-text="fotoName"></p>
                                    </div>
                                </template>

                                <input type="file" name="foto" x-ref="fotoInput" accept="image/jpeg,image/jpg,image/png" class="hidden"
                                       @change="handleFoto($event.target.files[0])">
                            </div>
                            <p x-show="errors.foto" x-text="errors.foto" class="text-red-500 text-xs mt-2" style="display:none"></p>
                        </div>
                    </div>
                </div>

                {{-- ===== STEP 4: REVIEW & KIRIM ===== --}}
                <div data-step="4" x-show="currentStep === 4" style="display:none">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-brand-lime flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-ink">Review & Kirim</p>
                            <p class="text-xs text-slate-500">Periksa lagi sebelum mengirim pengaduan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 rounded-2xl p-4 sm:p-5">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Data Diri</p>
                            <dl class="grid sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div><dt class="text-slate-400 text-xs">Nama</dt><dd class="text-ink font-medium" x-text="form.nama_pelapor || 'Belum diisi'"></dd></div>
                                <div><dt class="text-slate-400 text-xs">No. HP</dt><dd class="text-ink font-medium" x-text="form.no_hp || 'Belum diisi'"></dd></div>
                                <div><dt class="text-slate-400 text-xs">NPA</dt><dd class="text-ink font-medium" x-text="form.no_pelanggan || 'Tidak diisi'"></dd></div>
                                <div><dt class="text-slate-400 text-xs">Email</dt><dd class="text-ink font-medium" x-text="form.email || 'Tidak diisi'"></dd></div>
                                <div class="sm:col-span-2"><dt class="text-slate-400 text-xs">Alamat</dt><dd class="text-ink font-medium" x-text="form.alamat || 'Belum diisi'"></dd></div>
                                <div class="sm:col-span-2"><dt class="text-slate-400 text-xs">Patokan Rumah</dt><dd class="text-ink font-medium" x-text="form.no_rumah_patokan || 'Tidak diisi'"></dd></div>
                            </dl>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 sm:p-5">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Detail Pengaduan</p>
                            <dl class="space-y-2 text-sm">
                                <div><dt class="text-slate-400 text-xs">Kategori</dt><dd class="text-ink font-medium" x-text="categoryLabel || 'Belum dipilih'"></dd></div>
                                <div><dt class="text-slate-400 text-xs">Judul</dt><dd class="text-ink font-medium" x-text="form.judul || 'Belum diisi'"></dd></div>
                                <div><dt class="text-slate-400 text-xs">Deskripsi</dt><dd class="text-ink font-medium" x-text="form.deskripsi || 'Belum diisi'"></dd></div>
                            </dl>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 sm:p-5">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Lokasi & Foto</p>
                            <dl class="text-sm mb-3">
                                <dt class="text-slate-400 text-xs">Detail Lokasi Kejadian</dt>
                                <dd class="text-ink font-medium" x-text="form.lokasi_kejadian || 'Tidak diisi'"></dd>
                            </dl>
                            <div x-show="fotoPreview">
                                <p class="text-slate-400 text-xs mb-2">Foto Bukti</p>
                                <img :src="fotoPreview" class="max-h-40 rounded-xl shadow-sm">
                            </div>
                            <p x-show="!fotoPreview" class="text-slate-400 text-xs italic" style="display:none">Tidak ada foto dilampirkan</p>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-amber-700 text-sm" x-show="!isFormValid" style="display:none">
                            ⚠️ Masih ada data wajib yang belum lengkap atau belum valid. Silakan cek kembali Langkah 1 dan 2.
                        </div>

                        <div class="flex items-start gap-3 bg-brand-blue/5 rounded-2xl p-4">
                            <input type="checkbox" id="konfirmasi" x-model="konfirmasi" class="mt-0.5 w-4 h-4 accent-brand-blue">
                            <label for="konfirmasi" class="text-sm text-slate-600">
                                Saya menyatakan bahwa data dan informasi yang saya isi di atas benar dan dapat dipertanggungjawabkan.
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Navigasi tombol --}}
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                    <button type="button" @click="prevStep()" x-show="currentStep > 1" style="display:none"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-ink px-5 py-3 transition">
                        ← Kembali
                    </button>
                    <div x-show="currentStep === 1"></div>

                    <button type="button" @click="nextStep()" x-show="currentStep < 4"
                            class="ml-auto inline-flex items-center gap-2 bg-brand-blue text-white font-semibold rounded-xl px-6 py-3 shadow-lg shadow-brand-blue/30 hover:bg-brand-bluelight transition text-sm">
                        Lanjut →
                    </button>
                    <button type="submit" x-show="currentStep === 4" style="display:none"
                            :disabled="!konfirmasi"
                            :class="konfirmasi ? 'bg-brand-green hover:opacity-90 shadow-lg shadow-brand-green/30 cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                            class="ml-auto inline-flex items-center gap-2 text-white font-semibold rounded-xl px-6 py-3 transition text-sm">
                        Kirim Pengaduan ✓
                    </button>
                </div>
            </form>
        </div>
    @endif

</section>

<script>
function pengaduanForm() {
    return {
        currentStep: 1,
        dragging: false,
        fotoPreview: null,
        fotoName: '',
        konfirmasi: false,
        categoryLabel: @js(old('kategori_pengaduan_id') && isset($kategoris) ? optional($kategoris->firstWhere('id', (int) old('kategori_pengaduan_id')))->nama : ''),

        // errors: pesan error tiap field. touched: field mana yang sudah "disentuh" (blur/klik Lanjut/submit)
        // -> pesan error CUMA tampil kalau errors[field] ada DAN touched[field] true.
        errors: {},
        touched: {},

        form: {
            nama_pelapor: @js(old('nama_pelapor', '')),
            no_hp: @js(old('no_hp', '')),
            no_pelanggan: @js(old('no_pelanggan', '')),
            email: @js(old('email', '')),
            alamat: @js(old('alamat', '')),
            no_rumah_patokan: @js(old('no_rumah_patokan', '')),
            kategori_pengaduan_id: @js(old('kategori_pengaduan_id', '')),
            judul: @js(old('judul', '')),
            deskripsi: @js(old('deskripsi', '')),
            lokasi_kejadian: @js(old('lokasi_kejadian', '')),
        },

        rules: {
            nama_pelapor: { required: true, minLength: 3, maxLength: 255, pattern: /^[a-zA-Z\s.,'-]+$/, patternMsg: 'Nama hanya boleh berisi huruf.' },
            no_hp: { required: true, pattern: /^[0-9+]{9,15}$/, patternMsg: 'Nomor HP harus angka, 9-15 digit.' },
            no_pelanggan: { required: false, pattern: /^[0-9]*$/, patternMsg: 'Nomor Pelanggan hanya boleh berisi angka.' },
            email: { required: false, pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, patternMsg: 'Format email tidak valid.' },
            alamat: { required: true, minLength: 10, minLengthMsg: 'Alamat terlalu singkat, minimal 10 karakter.' },
            kategori_pengaduan_id: { required: true },
            judul: { required: true, minLength: 5, maxLength: 255, minLengthMsg: 'Judul minimal 5 karakter.' },
            deskripsi: { required: true, minLength: 20, minLengthMsg: 'Ceritakan lebih detail lagi, minimal 20 karakter.' },
        },

        stepFields: {
            1: ['nama_pelapor', 'no_hp', 'no_pelanggan', 'email', 'alamat'],
            2: ['kategori_pengaduan_id', 'judul', 'deskripsi'],
        },

        init() {
            // Kalau baru saja balik dari validasi server yang gagal, tandai field-field itu
            // sebagai "touched" supaya pesan errornya langsung kelihatan tanpa perlu diklik dulu.
            const serverErrors = @js($errors->any() ? collect($errors->messages())->map(fn($m) => $m[0])->toArray() : []);
            if (Object.keys(serverErrors).length) {
                Object.keys(serverErrors).forEach((field) => {
                    this.errors[field] = serverErrors[field];
                    this.touched[field] = true;
                });
                if (this.stepFields[1].some((f) => serverErrors[f])) this.currentStep = 1;
                else if (this.stepFields[2].some((f) => serverErrors[f])) this.currentStep = 2;
                else if (serverErrors.foto) this.currentStep = 3;
            }
        },

        validateField(field) {
            const rule = this.rules[field];
            if (!rule) return true;
            const value = (this.form[field] || '').toString().trim();

            if (rule.required && value === '') {
                this.errors[field] = 'Wajib diisi.';
                return false;
            }
            if (!rule.required && value === '') {
                delete this.errors[field];
                return true;
            }
            if (rule.minLength && value.length < rule.minLength) {
                this.errors[field] = rule.minLengthMsg || `Minimal ${rule.minLength} karakter.`;
                return false;
            }
            if (rule.maxLength && value.length > rule.maxLength) {
                this.errors[field] = `Maksimal ${rule.maxLength} karakter.`;
                return false;
            }
            if (rule.pattern && !rule.pattern.test(value)) {
                this.errors[field] = rule.patternMsg || 'Format tidak valid.';
                return false;
            }
            delete this.errors[field];
            return true;
        },

        validateFoto(file) {
            delete this.errors.foto;
            if (!file) return true;
            const allowed = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowed.includes(file.type)) {
                this.errors.foto = 'File harus berformat JPG, JPEG, atau PNG.';
                return false;
            }
            if (file.size > 5 * 1024 * 1024) {
                this.errors.foto = 'Ukuran file maksimal 5MB.';
                return false;
            }
            return true;
        },

        handleFoto(file) {
            if (!file) { this.fotoPreview = null; this.fotoName = ''; return; }
            if (this.validateFoto(file)) {
                this.fotoPreview = URL.createObjectURL(file);
                this.fotoName = file.name;
            } else {
                this.fotoPreview = null;
                this.fotoName = '';
                this.$refs.fotoInput.value = '';
            }
        },

        // Validasi 1 langkah. markTouched=true dipakai saat klik "Lanjut"/submit,
        // supaya semua field wajib di langkah itu jadi "touched" dan errornya kelihatan.
        validateStep(step, markTouched = false) {
            let valid = true;
            (this.stepFields[step] || []).forEach((field) => {
                if (markTouched) this.touched[field] = true;
                if (!this.validateField(field)) valid = false;
            });
            return valid;
        },

        get isFormValid() {
            return this.validateStep(1) && this.validateStep(2) && !this.errors.foto;
        },

        // Cari field pertama yang error di step tertentu, lalu fokus + scroll ke situ
        focusFirstError(step) {
            const fieldOrder = this.stepFields[step] || [];
            const firstErrorField = fieldOrder.find((f) => this.errors[f]);
            if (!firstErrorField) return;

            this.$nextTick(() => {
                const el = document.querySelector(`[name="${firstErrorField}"]`);
                if (el) {
                    el.focus();
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        },

        nextStep() {
            if (!this.validateStep(this.currentStep, true)) {
                this.focusFirstError(this.currentStep);
                return;
            }
            if (this.currentStep < 4) this.currentStep++;
            this.scrollToTop();
        },
        prevStep() {
            if (this.currentStep > 1) this.currentStep--;
            this.scrollToTop();
        },
        scrollToTop() {
            const top = document.getElementById('form-pengaduan').getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top, behavior: 'smooth' });
        },

        submitForm(event) {
            const step1Valid = this.validateStep(1, true);
            const step2Valid = this.validateStep(2, true);
            if (!step1Valid || !step2Valid || this.errors.foto || !this.konfirmasi) {
                event.preventDefault();
                if (!step1Valid) { this.currentStep = 1; this.focusFirstError(1); }
                else if (!step2Valid) { this.currentStep = 2; this.focusFirstError(2); }
                else { this.currentStep = 4; this.scrollToTop(); }
                return;
            }
            // Valid semua -> biarkan form submit normal
        },
    };
}
</script>
@endsection
