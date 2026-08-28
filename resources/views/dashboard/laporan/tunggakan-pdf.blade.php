<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Tunggakan — {{ now()->format('d-m-Y') }}</title>
    <style>
        @page { size: A4; margin: 0; }
        * { box-sizing: border-box; }
        body {
            padding: 14mm 17mm 16mm 17mm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #12233F;
            line-height: 1.35;
        }

        .kop { width: 100%; border-collapse: collapse; margin: 0 0 3px 0; }
        .kop-logo { width: 72px; text-align: center; vertical-align: middle; }
        .kop-logo img { width: 58px; height: 58px; object-fit: contain; }
        .kop-identitas { text-align: center; vertical-align: middle; padding-right: 50px; }
        .nama-instansi { margin: 0; font-size: 15.5px; font-weight: bold; color: #0B6FB4; }
        .nama-provinsi { margin: 1px 0 0 0; font-size: 12px; font-weight: bold; }
        .nama-cabang { margin: 1px 0 2px 0; font-size: 10px; font-weight: bold; color: #14958C; }
        .garis-utama { border-top: 3px solid #0B6FB4; margin-top: 4px; }
        .garis-kedua { border-top: 1px solid #8CC63F; margin-top: 2px; margin-bottom: 14px; }

        .judul-laporan { text-align: center; font-size: 14pt; font-weight: bold; color: #12233F; margin-bottom: 2px; text-transform: uppercase; }
        .subjudul-laporan { text-align: center; font-size: 9.5pt; color: #666666; margin-bottom: 14px; }

        .info-filter { width: 100%; border-collapse: collapse; margin-bottom: 14px; background: #FFF8ED; border: 1px solid #fde8c7; }
        .info-filter td { padding: 6px 10px; font-size: 9pt; }

        .kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .kpi-table td { width: 33.33%; padding: 4px; }
        .kpi-box { border: 1px solid #e2e8f0; border-radius: 4px; padding: 10px; text-align: center; }
        .kpi-label { font-size: 8pt; color: #64748b; }
        .kpi-value { font-size: 13pt; font-weight: bold; color: #d97706; margin-top: 2px; }

        .judul-section { font-size: 11pt; font-weight: bold; color: #0B6FB4; margin: 0 0 7px 0; border-bottom: 1px solid #d8e8f4; padding-bottom: 3px; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        table.data-table th { background: #FFF8ED; text-align: left; padding: 6px 8px; font-size: 8.5pt; color: #d97706; border-bottom: 2px solid #fde8c7; }
        table.data-table td { padding: 5px 8px; font-size: 9pt; border-bottom: 1px solid #f1f5f9; }
        table.data-table tr:nth-child(even) { background: #fafbfc; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 8px; font-size: 7.5pt; font-weight: bold; }
        .badge-amber { background: #fef3c7; color: #b45309; }
        .badge-cyan { background: #cffafe; color: #0e7490; }

        .footer {
            position: fixed;
            left: 17mm; right: 17mm; bottom: 6mm;
            border-top: 1px solid #0B6FB4;
            padding-top: 4px;
            font-size: 7.5pt;
            color: #64748b;
        }
    </style>
</head>
<body>

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
            </td>
        </tr>
    </table>
    <div class="garis-utama"></div>
    <div class="garis-kedua"></div>

    <div class="judul-laporan">Laporan Tunggakan</div>
    <div class="subjudul-laporan">Kondisi per {{ \App\Models\Pengaduan::formatTanggalIndo(now(), true) }}</div>

    <table class="info-filter">
        <tr>
            <td><strong>Kategori</strong><br>{{ count($kategoriIds) > 0 ? $kategoriList->whereIn('id', $kategoriIds)->pluck('nama')->implode(', ') : 'Semua Kategori' }}</td>
        </tr>
    </table>

    {{-- KPI --}}
    <table class="kpi-table">
        <tr>
            <td><div class="kpi-box"><div class="kpi-label">TOTAL TUNGGAKAN</div><div class="kpi-value">{{ \App\Models\Pengaduan::formatRupiah($totalTunggakan) }}</div></div></td>
            <td><div class="kpi-box"><div class="kpi-label">MENUNGGU PERSETUJUAN</div><div class="kpi-value" style="font-size:10.5pt">{{ $jumlahMenungguPersetujuan }} pengaduan<br>{{ \App\Models\Pengaduan::formatRupiah($totalMenungguPersetujuan) }}</div></div></td>
            <td><div class="kpi-box"><div class="kpi-label">MENUNGGU VERIFIKASI</div><div class="kpi-value" style="font-size:10.5pt; color:#0e7490">{{ $jumlahMenungguVerifikasi }} pengaduan<br>{{ \App\Models\Pengaduan::formatRupiah($totalMenungguVerifikasi) }}</div></div></td>
        </tr>
    </table>

    <div class="judul-section">Daftar Tunggakan ({{ $jumlahTunggakan }})</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nomor Pengaduan</th>
                <th>Pelanggan</th>
                <th>Kategori</th>
                <th>Status</th>
                <th class="text-right">Nominal</th>
                <th class="text-right">Lama Menunggu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftar as $item)
                <tr>
                    <td>{{ $item->kode_pengaduan }}</td>
                    <td>{{ $item->nama_pelapor }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $item->status === 'menunggu_persetujuan' ? 'badge-amber' : 'badge-cyan' }}">
                            {{ $item->status === 'menunggu_persetujuan' ? 'Nunggu Persetujuan' : 'Nunggu Verifikasi' }}
                        </span>
                    </td>
                    <td class="text-right">{{ $item->formattedTotalBiaya() }}</td>
                    <td class="text-right">{{ $item->tanggal_pemeriksaan ? \App\Models\Pengaduan::formatLamaMenunggu($item->tanggal_pemeriksaan) : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center; color:#94a3b8;">Tidak ada tunggakan saat ini 🎉</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        PERUMDA Tirtanadi Cabang Padang Bulan &middot; Laporan ini dibuat otomatis oleh sistem pengaduan pelanggan.
    </div>

</body>
</html>
