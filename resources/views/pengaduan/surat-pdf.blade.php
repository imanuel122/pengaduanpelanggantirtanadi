<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    @php
        /*
        |--------------------------------------------------------------------------
        | DATA PENGADUAN
        |--------------------------------------------------------------------------
        */
        $kategori = $pengaduan->kategori->nama ?? 'Pengaduan Pelanggan';
        $judul = trim($pengaduan->judul ?? 'Pengaduan Pelanggan');
        $deskripsi = trim($pengaduan->deskripsi ?? '');
        $status = $pengaduan->statusLabel();

        $kategoriLower = strtolower($kategori);
        $statusLower = strtolower($status);

        /*
        |--------------------------------------------------------------------------
        | HAL SURAT
        |--------------------------------------------------------------------------
        */
        $halSurat = 'Pengaduan ' . $kategori . ' – ' . $judul;

        /*
        |--------------------------------------------------------------------------
        | URAIAN BERDASARKAN KATEGORI (otomatis menyesuaikan isi keluhan)
        |--------------------------------------------------------------------------
        */
        if (str_contains($kategoriLower, 'bocor') || str_contains($kategoriLower, 'kebocoran')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan dugaan kebocoran pada jaringan perpipaan atau instalasi air di lokasi pelanggan.';
        } elseif (str_contains($kategoriLower, 'air') && (str_contains($kategoriLower, 'mati') || str_contains($kategoriLower, 'kecil') || str_contains($kategoriLower, 'tidak normal'))) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan gangguan atau kendala pada aliran air yang diterima pelanggan.';
        } elseif (str_contains($kategoriLower, 'meter')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan kondisi, fungsi, atau permasalahan pada meter air pelanggan.';
        } elseif (str_contains($kategoriLower, 'tagihan') || str_contains($kategoriLower, 'rekening')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan tagihan atau rekening air pelanggan.';
        } elseif (str_contains($kategoriLower, 'keruh') || str_contains($kategoriLower, 'berbau')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan kualitas air yang diterima pelanggan.';
        } elseif (str_contains($kategoriLower, 'sambungan') || str_contains($kategoriLower, 'pasang')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan pelayanan atau proses sambungan air pelanggan.';
        } elseif (str_contains($kategoriLower, 'limbah') || str_contains($kategoriLower, 'bak kontrol') || str_contains($kategoriLower, 'ic ')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan saluran air limbah atau sarana bak kontrol pelanggan.';
        } elseif (str_contains($kategoriLower, 'bor') || str_contains($kategoriLower, 'stratpot')) {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan sarana lubang bor atau stratpot pelanggan.';
        } else {
            $uraianKategori = 'Pengaduan yang disampaikan berkaitan dengan pelayanan PERUMDA Tirtanadi sebagaimana diuraikan oleh pelanggan.';
        }

        /*
        |--------------------------------------------------------------------------
        | KALIMAT STATUS (otomatis menyesuaikan status terkini)
        |--------------------------------------------------------------------------
        */
        if (str_contains($statusLower, 'selesai')) {
            $kalimatStatus = 'Berdasarkan status penanganan pada sistem, pengaduan tersebut tercatat telah selesai ditindaklanjuti oleh petugas terkait.';
        } elseif (str_contains($statusLower, 'proses')) {
            $kalimatStatus = 'Pengaduan tersebut saat ini sedang dalam proses tindak lanjut oleh petugas terkait.';
        } elseif (str_contains($statusLower, 'verifikasi')) {
            $kalimatStatus = 'Pengaduan tersebut saat ini sedang dalam tahap verifikasi oleh petugas terkait sebelum ditindaklanjuti lebih jauh.';
        } elseif (str_contains($statusLower, 'tolak')) {
            $kalimatStatus = 'Pengaduan tersebut telah mendapatkan tindak lanjut sesuai dengan hasil pemeriksaan dan ketentuan yang berlaku.';
        } else {
            $kalimatStatus = 'Pengaduan tersebut akan ditindaklanjuti oleh petugas terkait sesuai dengan prosedur dan ketentuan yang berlaku.';
        }
    @endphp

    <title>Surat Pengaduan {{ $pengaduan->kode_pengaduan }}</title>

    <style>
        /* @page margin dibuat 0, margin sesungguhnya diatur lewat padding BODY.
           Ini lebih konsisten di DomPDF supaya margin benar-benar terlihat. */
        @page { size: A4; margin: 0; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }

        body {
            padding: 14mm 17mm 18mm 17mm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #111111;
            line-height: 1.35;
        }

        /* ===== KOP SURAT ===== */
        .kop { width: 100%; border-collapse: collapse; margin: 0 0 3px 0; }
        .kop-logo { width: 72px; text-align: center; vertical-align: middle; }
        .kop-logo img { width: 58px; height: 58px; object-fit: contain; }
        .kop-identitas { text-align: center; vertical-align: middle; padding-right: 50px; }
        .nama-instansi { margin: 0; font-size: 15.5px; font-weight: bold; letter-spacing: 0.2px; color: #0B6FB4; }
        .nama-provinsi { margin: 1px 0 0 0; font-size: 12px; font-weight: bold; }
        .nama-cabang { margin: 1px 0 2px 0; font-size: 10px; font-weight: bold; color: #14958C; }
        .alamat-kop { margin: 2px 0 0 0; font-size: 8px; color: #333333; }
        .garis-utama { border-top: 3px solid #0B6FB4; margin-top: 4px; }
        .garis-kedua { border-top: 1px solid #8CC63F; margin-top: 2px; margin-bottom: 12px; }

        /* ===== IDENTITAS SURAT ===== */
        .identitas-surat { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .identitas-surat td { padding: 1px 0; vertical-align: top; font-size: 10pt; line-height: 1.3; }
        .identitas-surat .label { width: 68px; }
        .identitas-surat .colon { width: 14px; }

        .tanggal { text-align: right; font-size: 10pt; margin-bottom: 11px; }

        /* ===== TUJUAN ===== */
        .tujuan { margin-bottom: 11px; font-size: 10pt; line-height: 1.35; }
        .tujuan .nama { font-weight: bold; }

        /* ===== ISI SURAT ===== */
        .isi { margin: 0 0 7px 0; text-align: justify; font-size: 10pt; line-height: 1.38; }

        /* ===== URAIAN / KUTIPAN DESKRIPSI ===== */
        .uraian {
            margin: 5px 0 8px 12px;
            padding: 6px 10px;
            border-left: 2px solid #0B6FB4;
            font-size: 9.5pt;
            line-height: 1.38;
            text-align: justify;
            background-color: #F8FAFC;
        }

        /* ===== RINCIAN PENGADUAN ===== */
        .judul-data { margin-top: 8px; margin-bottom: 4px; font-size: 10pt; font-weight: bold; text-transform: uppercase; color: #0B6FB4; }
        .data { width: 100%; border-collapse: collapse; margin: 0 0 7px 0; }
        .data td { padding: 2px 2px; vertical-align: top; font-size: 9.3pt; line-height: 1.25; }
        .data .label { width: 145px; }
        .data .colon { width: 13px; }
        .data .value { text-align: left; font-weight: bold; }

        /* ===== NOMOR PENGADUAN ===== */
        .nomor-box { width: 100%; border: 1px solid #0B6FB4; background-color: #F0F7FC; border-collapse: collapse; margin-top: 6px; margin-bottom: 7px; }
        .nomor-box td { padding: 5px 9px; vertical-align: middle; }
        .nomor-label { width: 165px; font-size: 9pt; font-weight: bold; color: #14958C; }
        .nomor-value { font-size: 11.5pt; font-weight: bold; letter-spacing: 0.5px; color: #0B6FB4; }

        /* ===== QR CODE (2 buah berdampingan) ===== */
        .qr-table { width: 100%; border-collapse: collapse; margin: 3px 0 7px 0; }
        .qr-table td { vertical-align: middle; padding-right: 4px; }
        .qr-image { width: 58px; }
        .qr-image img { width: 50px; height: 50px; }
        .qr-text { padding-left: 6px; padding-right: 14px; font-size: 8pt; color: #444444; line-height: 1.3; }
        .qr-text strong { color: #0B6FB4; }

        /* ===== PENUTUP ===== */
        .penutup { margin: 7px 0 8px 0; text-align: justify; font-size: 10pt; line-height: 1.38; }

        /* ===== TANDA TANGAN ===== */
        .ttd { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .ttd-kosong { width: 57%; }
        .ttd-kanan { width: 43%; text-align: center; vertical-align: top; font-size: 9.5pt; line-height: 1.3; }
        .ttd-nama { margin-top: 38px; font-weight: bold; text-decoration: underline; }
        .ttd-jabatan { margin-top: 1px; }

        /* ===== FOOTER (tampil di semua halaman) ===== */
        .footer {
            position: fixed;
            left: 17mm; right: 17mm; bottom: 5mm;
            border-top: 1px solid #0B6FB4;
            padding-top: 4px;
            font-size: 7.2pt;
            color: #444444;
        }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-left { width: 65%; text-align: left; }
        .footer-right { width: 35%; text-align: right; }
        .footer-title { font-weight: bold; font-size: 7.8pt; color: #0B6FB4; }

        .kop, .identitas-surat, .tujuan, .uraian, .data, .nomor-box, .qr-table, .ttd {
            page-break-inside: avoid;
        }

        /* ===== HALAMAN LAMPIRAN FOTO (halaman baru, terpisah dari surat) ===== */
        .lampiran-page { page-break-before: always; }
        .lampiran-kop { border-bottom: 1.5px solid #0B6FB4; padding-bottom: 6px; margin-bottom: 16px; }
        .lampiran-title { font-size: 13pt; font-weight: bold; color: #0B6FB4; margin: 0; }
        .lampiran-sub { font-size: 8.5pt; color: #64748B; margin: 3px 0 0 0; }
        table.lampiran-grid { width: 100%; border-collapse: collapse; }
        table.lampiran-grid td { width: 50%; padding: 6px; vertical-align: top; }
        .lampiran-frame { border: 1px solid #E2E8F0; border-radius: 4px; padding: 6px; text-align: center; }
        .lampiran-frame img { width: 100%; max-height: 180px; object-fit: cover; }
        .lampiran-caption { font-size: 8pt; color: #64748B; margin-top: 4px; }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    <table class="kop">
        <tr>
            <td class="kop-logo">
                @if (file_exists(public_path('images/logo/logo-pdam.jpg')))
                    <img src="{{ public_path('images/logo/logo-pdam.jpg') }}" alt="Logo Tirtanadi">
                @endif
            </td>
            <td class="kop-identitas">
                <div class="nama-instansi">PERUMDA TIRTANADI</div>
                <div class="nama-provinsi">PROVINSI SUMATERA UTARA</div>
                <div class="nama-cabang">CABANG PADANG BULAN</div>
                <div class="alamat-kop">
                    Jl. Setia Budi, Padang Bulan, Medan &nbsp;|&nbsp; Telp. (061) 8360432 &nbsp;|&nbsp; Halo Tirtanadi 1500-922
                </div>
            </td>
        </tr>
    </table>
    <div class="garis-utama"></div>
    <div class="garis-kedua"></div>

    {{-- ===== IDENTITAS SURAT ===== --}}
    <table class="identitas-surat">
        <tr>
            <td class="label">Nomor</td><td class="colon">:</td>
            <td>{{ $pengaduan->kode_pengaduan }}</td>
        </tr>
        <tr>
            <td class="label">Sifat</td><td class="colon">:</td>
            <td>Pengaduan Pelanggan</td>
        </tr>
        <tr>
            <td class="label">Lampiran</td><td class="colon">:</td>
            <td>{{ $pengaduan->fotos->count() > 0 ? $pengaduan->fotos->count() . ' berkas foto' : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Hal</td><td class="colon">:</td>
            <td><strong>{{ $halSurat }}</strong></td>
        </tr>
    </table>

    <div class="tanggal">Medan, {{ $tanggalIndo }}</div>

    {{-- ===== TUJUAN ===== --}}
    <div class="tujuan">
        <div>Kepada Yth.</div>
        <div class="nama">Bapak/Ibu {{ $pengaduan->nama_pelapor }}</div>
        <div>{{ $pengaduan->alamat }}</div>
        <div>di Tempat</div>
    </div>

    {{-- ===== ISI SURAT ===== --}}
    <p class="isi">Dengan hormat,</p>

    <p class="isi">
        Menanggapi pengaduan yang telah disampaikan oleh Bapak/Ibu <strong>{{ $pengaduan->nama_pelapor }}</strong>
        melalui sistem pengaduan online <strong>PERUMDA Tirtanadi Cabang Padang Bulan</strong>,
        bersama ini kami sampaikan bahwa pengaduan mengenai <strong>{{ $kategori }}</strong>
        dengan judul <strong>&ldquo;{{ $judul }}&rdquo;</strong> telah kami terima dan tercatat
        dalam sistem pengaduan kami.
    </p>

    <p class="isi">
        {{ $uraianKategori }} Adapun uraian permasalahan yang disampaikan oleh Bapak/Ibu adalah sebagai berikut:
    </p>

    @if ($deskripsi !== '')
        <div class="uraian">&ldquo;{{ $deskripsi }}&rdquo;</div>
    @endif

    <p class="isi">{{ $kalimatStatus }}</p>

    {{-- ===== RINCIAN PENGADUAN ===== --}}
    <div class="judul-data">Rincian Pengaduan</div>
    <table class="data">
        <tr><td class="label">Nama Pelapor</td><td class="colon">:</td><td class="value">{{ $pengaduan->nama_pelapor }}</td></tr>
        <tr><td class="label">Nomor Pelanggan (NPA)</td><td class="colon">:</td><td class="value">{{ $pengaduan->no_pelanggan ?: '-' }}</td></tr>
        <tr><td class="label">Nomor HP</td><td class="colon">:</td><td class="value">{{ $pengaduan->no_hp ?: '-' }}</td></tr>
        <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">{{ $pengaduan->alamat }}</td></tr>
        <tr><td class="label">Kategori Pengaduan</td><td class="colon">:</td><td class="value">{{ $kategori }}</td></tr>
        <tr><td class="label">Judul Pengaduan</td><td class="colon">:</td><td class="value">{{ $judul }}</td></tr>
        <tr><td class="label">Status Pengaduan</td><td class="colon">:</td><td class="value">{{ $status }}</td></tr>
        <tr><td class="label">Tanggal Pengaduan</td><td class="colon">:</td><td class="value">{{ $tanggalIndo }}</td></tr>
    </table>

    {{-- ===== NOMOR PENGADUAN ===== --}}
    <table class="nomor-box">
        <tr>
            <td class="nomor-label">NOMOR PENGADUAN</td>
            <td class="nomor-value">{{ $pengaduan->kode_pengaduan }}</td>
        </tr>
    </table>

    {{-- ===== 2 QR CODE BERDAMPINGAN ===== --}}
    <table class="qr-table">
        <tr>
            @if (!empty($qrSuratBase64))
                <td class="qr-image"><img src="data:image/svg+xml;base64,{{ $qrSuratBase64 }}" alt="QR Surat"></td>
                <td class="qr-text">
                    <strong>Lihat / Cetak Ulang Surat.</strong> Pindai untuk membuka
                    kembali atau mencetak ulang surat ini.
                </td>
            @endif
            @if (!empty($qrLacakBase64))
                <td class="qr-image"><img src="data:image/svg+xml;base64,{{ $qrLacakBase64 }}" alt="QR Lacak"></td>
                <td class="qr-text">
                    <strong>Lacak Pengaduan.</strong> Pindai untuk memantau perkembangan
                    status pengaduan Anda kapan saja.
                </td>
            @endif
        </tr>
    </table>

    {{-- ===== PENUTUP ===== --}}
    <p class="penutup">
        Demikian surat ini kami sampaikan sebagai tanda terima atas pengaduan yang telah
        Bapak/Ibu sampaikan. Atas perhatian, kerja sama, dan kesediaan Bapak/Ibu menunggu
        proses penanganan pengaduan, kami ucapkan terima kasih.
    </p>

    {{-- ===== TANDA TANGAN ===== --}}
    <table class="ttd">
        <tr>
            <td class="ttd-kosong"></td>
            <td class="ttd-kanan">
                <div>Hormat kami,</div>
                <div class="ttd-nama">Admin Pengaduan</div>
                <div class="ttd-jabatan">PERUMDA Tirtanadi</div>
                <div class="ttd-jabatan">Cabang Padang Bulan</div>
            </td>
        </tr>
    </table>

    {{-- ===== FOOTER (muncul di semua halaman, termasuk lampiran) ===== --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="footer-left">
                    <div class="footer-title">PERUMDA TIRTANADI</div>
                    <div>Provinsi Sumatera Utara &nbsp;|&nbsp; Cabang Padang Bulan</div>
                </td>
                <td class="footer-right">
                    www.tirtanadi.co.id<br>
                    Halo Tirtanadi 1500-922
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== HALAMAN LAMPIRAN FOTO — HALAMAN BARU, TERPISAH DARI SURAT ===== --}}
    @if ($pengaduan->fotos->count() > 0)
        <div class="lampiran-page">
            <div class="lampiran-kop">
                <p class="lampiran-title">Lampiran Foto Pengaduan</p>
                <p class="lampiran-sub">
                    Melampiri Surat Nomor {{ $pengaduan->kode_pengaduan }} &mdash;
                    {{ $pengaduan->fotos->count() }} foto dilampirkan
                </p>
            </div>

            <table class="lampiran-grid">
                @php $nomorFoto = 0; @endphp
                @foreach ($pengaduan->fotos->chunk(2) as $baris)
                    <tr>
                        @foreach ($baris as $foto)
                            @php $nomorFoto++; $fotoPath = storage_path('app/public/' . $foto->path); @endphp
                            <td>
                                <div class="lampiran-frame">
                                    @if (file_exists($fotoPath))
                                        <img src="{{ $fotoPath }}">
                                    @endif
                                    <div class="lampiran-caption">Foto {{ $nomorFoto }}</div>
                                </div>
                            </td>
                        @endforeach
                        @if ($baris->count() < 2)
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

</body>
</html>