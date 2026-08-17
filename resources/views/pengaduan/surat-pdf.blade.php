<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengaduan {{ $pengaduan->kode_pengaduan }}</title>
    <style>
        @page { margin: 90px 60px 70px 60px; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* Garis aksen biru di kiri halaman, meniru desain kertas surat asli */
        .side-bar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 10px;
            background: linear-gradient(180deg, #0B6FB4, #14958C, #3FA75B, #8CC63F);
        }

        /* ===== HEADER / KOP SURAT ===== */
        header {
            position: fixed;
            top: -70px; left: 0; right: 0;
            height: 70px;
        }
        .logo-cell { width: 60px; vertical-align: middle; }
        .logo-cell img { width: 50px; height: 50px; }
        .brand-cell { vertical-align: middle; padding-left: 10px; }
        .brand-name { font-size: 22px; font-weight: bold; color: #0B6FB4; margin: 0; letter-spacing: 0.5px; }
        .brand-tagline { font-size: 9px; color: #14958C; margin: 0; font-style: italic; }
        .header-line { border-bottom: 2px solid #0B6FB4; margin-top: 6px; }

        /* ===== FOOTER ===== */
        footer {
            position: fixed;
            bottom: -60px; left: 0; right: 0;
            height: 60px;
            border-top: 1.5px solid #0B6FB4;
            padding-top: 8px;
            font-size: 8.5px;
            color: #0B6FB4;
        }
        footer .company { font-weight: bold; font-size: 10px; color: #12233F; }
        footer .sub { color: #64748B; }

        /* ===== ISI SURAT ===== */
        .info-table { width: 100%; margin-bottom: 4px; }
        .info-table td { padding: 1px 0; vertical-align: top; }
        .info-label { width: 75px; }
        .info-colon { width: 10px; }

        .tanggal { text-align: right; margin-bottom: 18px; }

        .kepada { margin-bottom: 16px; }
        .kepada .label { color: #444; }
        .kepada .nama { font-weight: bold; }

        p.isi { text-align: justify; margin: 0 0 12px 0; }

        table.data-pengaduan {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 16px 0;
        }
        table.data-pengaduan td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 10.5px;
        }
        table.data-pengaduan .dt-label { width: 130px; color: #444; }
        table.data-pengaduan .dt-colon { width: 12px; }
        table.data-pengaduan .dt-value { font-weight: bold; color: #12233F; }

        .kode-box {
            border: 1.5px solid #0B6FB4;
            border-radius: 6px;
            padding: 10px 14px;
            margin: 14px 0;
            background-color: #F0F7FC;
        }
        .kode-box .label { font-size: 9px; color: #14958C; text-transform: uppercase; letter-spacing: 0.5px; }
        .kode-box .kode { font-size: 16px; font-weight: bold; color: #0B6FB4; letter-spacing: 1px; }

        .qr-section { margin-top: 14px; }
        .qr-section img { width: 80px; height: 80px; }
        .qr-caption { font-size: 8.5px; color: #64748B; width: 200px; padding-left: 10px; }

        .ttd-table { width: 100%; margin-top: 30px; }
        .ttd-table td { vertical-align: top; }
        .ttd-right { width: 220px; text-align: center; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 55px; margin-bottom: 2px; }
        .ttd-jabatan { color: #444; }

        .status-badge {
            display: inline;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9.5px;
            font-weight: bold;
            background-color: #DBEAFE;
            color: #0B6FB4;
        }
    </style>
</head>
<body>

    <div class="side-bar"></div>

    <header>
        <table style="width:100%; border-collapse: collapse;">
            <tr>
                <td class="logo-cell">
                    @if (file_exists(public_path('images/logo/logo-pdam.jpg')))
                        <img src="{{ public_path('images/logo/logo-pdam.jpg') }}">
                    @endif
                </td>
                <td class="brand-cell">
                    <p class="brand-name">tirtanadi</p>
                    <p class="brand-tagline">Mengalir Melengkapi Hari</p>
                </td>
            </tr>
        </table>
        <div class="header-line"></div>
    </header>

    <footer>
        <p class="company">PERUMDA TIRTANADI &mdash; CABANG PADANG BULAN</p>
        <p class="sub">
            Jl. Setia Budi, Padang Bulan, Medan &nbsp;|&nbsp; Telp. (061) 1500-922 &nbsp;|&nbsp;
            Email. tirtanadi.padangbulan@gmail.com &nbsp;|&nbsp; www.tirtanadi.co.id
        </p>
    </footer>

    {{-- ===== KONTEN ===== --}}

    <table class="info-table">
        <tr>
            <td class="info-label">Nomor</td>
            <td class="info-colon">:</td>
            <td>{{ $pengaduan->kode_pengaduan }}</td>
        </tr>
        <tr>
            <td class="info-label">Sifat</td>
            <td class="info-colon">:</td>
            <td>Pengaduan Pelanggan</td>
        </tr>
        <tr>
            <td class="info-label">Lampiran</td>
            <td class="info-colon">:</td>
            <td>{{ $pengaduan->foto ? '1 (satu) berkas foto' : '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Hal</td>
            <td class="info-colon">:</td>
            <td><strong>Tanda Terima Pengaduan Pelanggan</strong></td>
        </tr>
    </table>

    <div class="tanggal">Medan, {{ $tanggalIndo }}</div>

    <div class="kepada">
        <div class="label">Kepada Yth,</div>
        <div class="nama">Bapak/Ibu {{ $pengaduan->nama_pelapor }}</div>
        <div>{{ $pengaduan->alamat }}</div>
        <div>di Tempat</div>
    </div>

    <p class="isi">
        Sehubungan dengan pengaduan yang Bapak/Ibu sampaikan melalui sistem pengaduan online
        PERUMDA Tirtanadi Cabang Padang Bulan, bersama ini kami sampaikan bahwa pengaduan Anda
        <strong>telah kami terima</strong> dan akan segera ditindaklanjuti oleh petugas kami.
        Berikut rincian pengaduan yang telah dicatat dalam sistem kami:
    </p>

    <table class="data-pengaduan">
        <tr>
            <td class="dt-label">Nama Pelapor</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->nama_pelapor }}</td>
        </tr>
        <tr>
            <td class="dt-label">Nomor Pelanggan (NPA)</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->no_pelanggan ?: '-' }}</td>
        </tr>
        <tr>
            <td class="dt-label">Nomor HP</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->no_hp }}</td>
        </tr>
        <tr>
            <td class="dt-label">Alamat</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->alamat }}</td>
        </tr>
        <tr>
            <td class="dt-label">Kategori Pengaduan</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->kategori->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="dt-label">Judul Pengaduan</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $pengaduan->judul }}</td>
        </tr>
        <tr>
            <td class="dt-label">Deskripsi</td><td class="dt-colon">:</td>
            <td class="dt-value" style="font-weight: normal;">{{ $pengaduan->deskripsi }}</td>
        </tr>
        <tr>
            <td class="dt-label">Status Saat Ini</td><td class="dt-colon">:</td>
            <td class="dt-value"><span class="status-badge">{{ $pengaduan->statusLabel() }}</span></td>
        </tr>
        <tr>
            <td class="dt-label">Tanggal Pengaduan</td><td class="dt-colon">:</td>
            <td class="dt-value">{{ $tanggalIndo }}</td>
        </tr>
    </table>

    <div class="kode-box">
        <div class="label">Nomor Pengaduan Anda (simpan baik-baik)</div>
        <div class="kode">{{ $pengaduan->kode_pengaduan }}</div>
    </div>

    <table class="qr-section" style="width:100%;">
        <tr>
            <td style="width: 90px;">
                @if (!empty($qrCodeBase64))
                    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}">
                @endif
            </td>
            <td class="qr-caption">
                Pindai (scan) kode QR di samping, atau kunjungi halaman <strong>Lacak Pengaduan</strong>
                pada website kami dan masukkan nomor pengaduan di atas untuk memantau
                perkembangan penanganan pengaduan Anda kapan saja.
            </td>
        </tr>
    </table>

    <p class="isi" style="margin-top: 14px;">
        Demikian surat tanda terima ini kami sampaikan. Atas perhatian dan kesabaran Bapak/Ibu
        menunggu proses penanganan, kami ucapkan terima kasih.
    </p>

    <table class="ttd-table">
        <tr>
            <td></td>
            <td class="ttd-right">
                <div>Hormat Kami,</div>
                <div class="ttd-nama">Admin Pengaduan</div>
                <div class="ttd-jabatan">PERUMDA Tirtanadi Cabang Padang Bulan</div>
            </td>
        </tr>
    </table>

</body>
</html>
