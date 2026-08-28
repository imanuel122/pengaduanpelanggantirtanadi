<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    @php
        use App\Models\Pengaduan;

        $kategori = $pengaduan->kategori->nama ?? 'Pengaduan Pelanggan';
        $judul = trim($pengaduan->judul ?? 'Pengaduan Pelanggan');
        $ada = fn ($nilai) => !is_null($nilai) && (float) $nilai > 0;

        /*
        |--------------------------------------------------------------------------
        | KONTEN PER JENIS SURAT — Hal, isi, dan rincian tambahan menyesuaikan
        | tahapan status. Templatnya (kop, identitas, ttd, footer) tetap sama
        | persis dengan Surat Pengaduan, cuma isinya yang beda per kondisi.
        |--------------------------------------------------------------------------
        */
        if ($jenis === 'pengecekan') {
            $halSurat = 'Pemberitahuan Jadwal Pengecekan — ' . $kategori;
            $paragrafIsi = [
                "Sehubungan dengan pengaduan yang telah Bapak/Ibu {$pengaduan->nama_pelapor} sampaikan mengenai {$kategori} dengan judul \"{$judul}\", bersama surat ini kami sampaikan bahwa pengaduan tersebut akan segera kami tindaklanjuti dengan pengecekan langsung ke lokasi oleh petugas kami.",
                'Sehubungan dengan hal tersebut, kami mohon kesediaan Bapak/Ibu untuk dapat ditemui di lokasi pada jadwal yang telah kami tentukan berikut, guna memperlancar pelaksanaan pengecekan.',
            ];
            $rincianTambahan = [
                'Petugas Pemeriksa' => $pengaduan->petugas_pengecekan_nama ?: '-',
                'Jadwal Pengecekan' => Pengaduan::formatTanggalIndo($pengaduan->jadwal_pengecekan, true),
            ];
            $kalimatPenutup = 'Demikian surat pemberitahuan ini kami sampaikan. Atas perhatian dan kerja sama yang baik dari Bapak/Ibu, kami ucapkan terima kasih.';
        } elseif ($jenis === 'hasil_pengecekan') {
            $halSurat = 'Pemberitahuan Hasil Pengecekan — ' . $kategori;
            $paragrafIsi = [
                "Sehubungan dengan pengaduan yang telah Bapak/Ibu {$pengaduan->nama_pelapor} sampaikan mengenai {$kategori} dengan judul \"{$judul}\", bersama surat ini kami sampaikan bahwa petugas kami telah selesai melaksanakan pengecekan dan pemeriksaan langsung di lokasi.",
            ];
            $rincianTambahan = [
                'Hasil Pemeriksaan' => $pengaduan->hasil_pemeriksaan ?: '-',
                'Status SPKP' => $pengaduan->perluSpkpLabel(),
            ];
            if ($ada($pengaduan->total_biaya)) {
                $paragrafIsi[] = 'Berdasarkan hasil pemeriksaan tersebut, diperlukan tindak lanjut yang disertai biaya sebesar ' . $pengaduan->formattedTotalBiaya() . ' yang perlu ditanggung oleh Bapak/Ibu selaku pelanggan. Rincian biaya selengkapnya dapat dilihat pada dokumen yang telah kami lampirkan di halaman Lacak Pengaduan.';
                $paragrafIsi[] = 'Kami mohon kesediaan Bapak/Ibu untuk memberikan persetujuan atas biaya tersebut melalui halaman Lacak Pengaduan, agar pengaduan ini dapat segera kami lanjutkan.';
                $rincianTambahan['Total Biaya'] = $pengaduan->formattedTotalBiaya();
            } else {
                $paragrafIsi[] = 'Berdasarkan hasil pemeriksaan tersebut, kami sampaikan bahwa pengaduan ini tidak dikenakan biaya apapun kepada Bapak/Ibu, dan akan segera kami lanjutkan ke tahap berikutnya.';
            }
            $kalimatPenutup = 'Demikian surat pemberitahuan hasil pengecekan ini kami sampaikan. Atas perhatian dan kerja sama yang baik dari Bapak/Ibu, kami ucapkan terima kasih.';
        } elseif ($jenis === 'verifikasi_pengaduan') {
            $halSurat = 'Pemberitahuan Verifikasi Pengaduan — ' . $kategori;
            $paragrafIsi = [
                "Menindaklanjuti hasil pengecekan atas pengaduan Bapak/Ibu {$pengaduan->nama_pelapor} mengenai {$kategori} dengan judul \"{$judul}\", bersama surat ini kami sampaikan bahwa pengaduan tersebut telah dinyatakan terverifikasi dan disetujui untuk dilanjutkan ke tahap berikutnya.",
            ];
            $rincianTambahan = [];
            if ($ada($pengaduan->total_biaya)) {
                $paragrafIsi[] = 'Bersama ini kami sampaikan pula bahwa pembayaran sebesar ' . $pengaduan->formattedTotalBiaya() . ' telah kami terima dan verifikasi dari Bapak/Ibu. Bukti pembayaran turut kami lampirkan pada halaman berikutnya sebagai bagian yang tidak terpisahkan dari surat ini.';
                $rincianTambahan['Total Biaya'] = $pengaduan->formattedTotalBiaya();
                $rincianTambahan['Status Pembayaran'] = 'Telah Dibayar & Terverifikasi';
                if ($pengaduan->tanggal_persetujuan) {
                    $rincianTambahan['Tanggal Pembayaran'] = Pengaduan::formatTanggalIndo($pengaduan->tanggal_persetujuan, true);
                }
            } else {
                $paragrafIsi[] = 'Sebagaimana telah disampaikan sebelumnya, pengaduan ini tidak dikenakan biaya apapun, sehingga tidak terdapat kewajiban pembayaran dari pihak Bapak/Ibu.';
            }
            $kalimatPenutup = 'Demikian surat pemberitahuan ini kami sampaikan. Pengaduan ini akan segera kami tindaklanjuti pada tahap berikutnya. Atas kepercayaan dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.';
        } elseif ($jenis === 'proses') {
            $halSurat = 'Pemberitahuan Proses Penanganan — ' . $kategori;
            $paragrafIsi = [
                "Menindaklanjuti hasil verifikasi atas pengaduan Bapak/Ibu {$pengaduan->nama_pelapor} mengenai {$kategori} dengan judul \"{$judul}\", bersama surat ini kami sampaikan bahwa pengaduan tersebut telah mulai kami tindaklanjuti.",
            ];
            $rincianTambahan = [
                'Petugas Pelaksana' => $pengaduan->pelaksana_proses_nama ?: '-',
                'Tanggal Mulai Penanganan' => Pengaduan::formatTanggalIndo($pengaduan->tanggal_mulai_proses, true),
            ];
            $kalimatPenutup = 'Demikian surat pemberitahuan ini kami sampaikan. Atas kesabaran dan pengertian Bapak/Ibu selama proses penanganan berlangsung, kami ucapkan terima kasih.';
        } elseif ($jenis === 'selesai') {
            $halSurat = 'Keterangan Penyelesaian Pengaduan — ' . $kategori;
            $paragrafIsi = [
                "Dengan ini kami sampaikan bahwa pengaduan Bapak/Ibu {$pengaduan->nama_pelapor} mengenai {$kategori} dengan judul \"{$judul}\" telah selesai kami tindaklanjuti dan tangani sepenuhnya.",
            ];
            $rincianTambahan = [
                'Tanggal Selesai' => Pengaduan::formatTanggalIndo($pengaduan->tanggal_selesai, true),
                'Catatan Penyelesaian' => $pengaduan->catatan_selesai ?: '-',
            ];
            $kalimatPenutup = 'Surat ini dapat dijadikan sebagai bukti bahwa pengaduan Bapak/Ibu telah selesai kami tangani. Apabila di kemudian hari masih ditemukan kendala yang serupa, Bapak/Ibu dapat menyampaikan pengaduan baru melalui sistem kami. Atas kepercayaan Bapak/Ibu terhadap layanan kami, kami ucapkan terima kasih.';
        } else { // ditolak
            $halSurat = 'Pemberitahuan Penolakan Pengaduan — ' . $kategori;
            if ($pengaduan->ditolakOlehAdmin()) {
                $paragrafIsi = [
                    "Sehubungan dengan pengaduan yang telah Bapak/Ibu {$pengaduan->nama_pelapor} sampaikan mengenai {$kategori} dengan judul \"{$judul}\", dengan penuh permohonan maaf kami sampaikan bahwa pengaduan tersebut belum dapat kami tindaklanjuti, dengan keterangan sebagai berikut.",
                ];
            } else {
                $paragrafIsi = [
                    "Sehubungan dengan pengaduan yang telah Bapak/Ibu {$pengaduan->nama_pelapor} sampaikan mengenai {$kategori} dengan judul \"{$judul}\", dengan ini kami sampaikan bahwa pengaduan tersebut telah dibatalkan sesuai permintaan Bapak/Ibu sendiri, dengan keterangan sebagai berikut.",
                ];
            }
            $rincianTambahan = [
                'Alasan Penolakan' => $pengaduan->alasanPenolakan() ?: '-',
            ];
            if ($ada($pengaduan->total_biaya)) {
                $rincianTambahan['Total Biaya yang Diajukan'] = $pengaduan->formattedTotalBiaya();
            }
            $paragrafIsi[] = $pengaduan->ditolakOlehAdmin()
                ? 'Apabila Bapak/Ibu memerlukan informasi lebih lanjut mengenai keputusan ini, silakan menghubungi kami melalui layanan pelanggan yang tersedia.'
                : 'Apabila sewaktu-waktu kendala tersebut masih berlanjut, Bapak/Ibu dapat menyampaikan pengaduan baru kembali melalui sistem kami.';
            $kalimatPenutup = 'Demikian surat pemberitahuan ini kami sampaikan. Atas pengertian Bapak/Ibu, kami ucapkan terima kasih.';
        }
    @endphp

    <title>{{ $halSurat }} — {{ $pengaduan->kode_pengaduan }}</title>

    <style>
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
        .isi { margin: 0 0 7px 0; text-align: justify; font-size: 10pt; line-height: 1.38; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word; }

        /* ===== RINCIAN ===== */
        .judul-data { margin-top: 8px; margin-bottom: 4px; font-size: 10pt; font-weight: bold; text-transform: uppercase; color: #0B6FB4; }
        .data { width: 100%; border-collapse: collapse; margin: 0 0 7px 0; }
        .data td { padding: 2px 2px; vertical-align: top; font-size: 9.3pt; line-height: 1.25; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word; }
        .data .label { width: 145px; }
        .data .colon { width: 13px; }
        .data .value { text-align: left; font-weight: bold; width: 320px; }

        /* ===== NOMOR PENGADUAN ===== */
        .nomor-box { width: 100%; border: 1px solid #0B6FB4; background-color: #F0F7FC; border-collapse: collapse; margin-top: 6px; margin-bottom: 7px; }
        .nomor-box td { padding: 5px 9px; vertical-align: middle; }
        .nomor-label { width: 165px; font-size: 9pt; font-weight: bold; color: #14958C; }
        .nomor-value { font-size: 11.5pt; font-weight: bold; letter-spacing: 0.5px; color: #0B6FB4; }
        .status-value { font-size: 9.5pt; font-weight: bold; color: #14958C; }

        /* ===== LAMPIRAN (halaman baru) ===== */
        .halaman-lampiran { page-break-before: always; }
        .lampiran-judul { font-size: 12pt; font-weight: bold; color: #0B6FB4; text-align: center; margin: 4mm 0 2mm 0; }
        .lampiran-subjudul { font-size: 9pt; text-align: center; color: #444444; margin-bottom: 8mm; }
        .lampiran-grid { width: 100%; border-collapse: collapse; }
        .lampiran-grid td { text-align: center; padding: 4mm; vertical-align: top; }
        .lampiran-grid img { max-width: 100%; max-height: 75mm; border: 1px solid #cccccc; border-radius: 3px; }
        .lampiran-caption { font-size: 8pt; color: #666666; margin-top: 2mm; }

        /* ===== QR CODE (2 buah berdampingan) ===== */
        .qr-table { width: 100%; border-collapse: collapse; margin: 3px 0 7px 0; }
        .qr-table td { vertical-align: middle; padding-right: 4px; }
        .qr-image { width: 92px; }
        .qr-image img { width: 82px; height: 82px; }
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

        /* ===== FOOTER ===== */
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

        .kop, .identitas-surat, .tujuan, .data, .nomor-box, .qr-table, .ttd {
            page-break-inside: avoid;
        }
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
            <td>Pemberitahuan</td>
        </tr>
        <tr>
            <td class="label">Lampiran</td><td class="colon">:</td>
            <td>{{ count($fotoLampiran ?? []) > 0 ? count($fotoLampiran) . ' lembar foto dokumentasi' : '-' }}</td>
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

    @foreach ($paragrafIsi as $paragraf)
        <p class="isi">{{ $paragraf }}</p>
    @endforeach

    {{-- ===== RINCIAN ===== --}}
    <div class="judul-data">Rincian</div>
    <table class="data">
        <tr><td class="label">Nama Pelapor</td><td class="colon">:</td><td class="value">{{ $pengaduan->nama_pelapor }}</td></tr>
        <tr><td class="label">Kategori Pengaduan</td><td class="colon">:</td><td class="value">{{ $kategori }}</td></tr>
        <tr><td class="label">Judul Pengaduan</td><td class="colon">:</td><td class="value">{{ $judul }}</td></tr>
        <tr><td class="label">Status Pengaduan Saat Ini</td><td class="colon">:</td><td class="value">{{ $pengaduan->statusLabel() }}</td></tr>
        @foreach ($rincianTambahan as $label => $value)
            <tr><td class="label">{{ $label }}</td><td class="colon">:</td><td class="value">{{ $value }}</td></tr>
        @endforeach
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
    <p class="penutup">{{ $kalimatPenutup }}</p>

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

    {{-- ===== LAMPIRAN FOTO (halaman terpisah) ===== --}}
    @if (count($fotoLampiran ?? []) > 0)
        <div class="halaman-lampiran">
            <div class="lampiran-judul">LAMPIRAN</div>
            <div class="lampiran-subjudul">
                {{ $jenis === 'hasil_pengecekan' ? 'Dokumentasi Foto Hasil Pengecekan Lapangan' : 'Dokumentasi Foto Bukti Pembayaran' }}
                — {{ $pengaduan->kode_pengaduan }}
            </div>
            <table class="lampiran-grid">
                <tr>
                    @foreach ($fotoLampiran as $i => $path)
                        <td style="width: {{ 100 / min(count($fotoLampiran), 2) }}%;">
                            <img src="{{ storage_path('app/public/' . $path) }}" alt="Lampiran">
                            <div class="lampiran-caption">Gambar {{ $i + 1 }}</div>
                        </td>
                        @if ($i % 2 === 1 && !$loop->last)
                            </tr><tr>
                        @endif
                    @endforeach
                </tr>
            </table>
        </div>
    @endif

    {{-- ===== FOOTER ===== --}}
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

</body>
</html>
