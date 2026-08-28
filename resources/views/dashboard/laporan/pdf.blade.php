<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan — {{ $dari->format('d-m-Y') }} s.d {{ $sampai->format('d-m-Y') }}</title>
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

        .info-filter { width: 100%; border-collapse: collapse; margin-bottom: 14px; background: #F0F7FC; border: 1px solid #d8e8f4; }
        .info-filter td { padding: 6px 10px; font-size: 9pt; }

        .kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .kpi-table td { width: 25%; padding: 4px; }
        .kpi-box { border: 1px solid #e2e8f0; border-radius: 4px; padding: 10px; text-align: center; }
        .kpi-label { font-size: 8pt; color: #64748b; }
        .kpi-value { font-size: 16pt; font-weight: bold; color: #0B6FB4; margin-top: 2px; }

        .section { page-break-inside: avoid; margin-bottom: 16px; }
        .judul-section { font-size: 11pt; font-weight: bold; color: #0B6FB4; margin: 0 0 7px 0; border-bottom: 1px solid #d8e8f4; padding-bottom: 3px; }

        /* ===== Tabel rekap gabungan: label + bar visual + angka + persen, SATU tabel saja ===== */
        /* (sebelumnya bar chart & tabel angka dipisah dan isinya duplikat -- sekarang digabung) */
        table.rekap-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        table.rekap-table th { background: #F0F7FC; text-align: left; padding: 6px 8px; font-size: 8.5pt; color: #0B6FB4; border-bottom: 2px solid #d8e8f4; }
        table.rekap-table td { padding: 5px 8px; font-size: 9pt; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        table.rekap-table tr:nth-child(even) td { background: #fafbfc; }
        .rekap-label { width: 34%; color: #334155; }
        .rekap-bar-cell { width: 30%; }
        .rekap-bar-track { background: #f1f5f9; border-radius: 3px; }
        .rekap-bar-fill { height: 12px; border-radius: 3px; }
        .rekap-jumlah { width: 16%; text-align: right; font-weight: bold; color: #12233F; }
        .rekap-persen { width: 16%; text-align: right; color: #64748b; }
        .text-right { text-align: right; }

        /* ===== Tabel titik data tren (pelengkap grafik, biar titiknya kebaca persis) ===== */
        /* ===== Tabel titik data tren (pelengkap grafik) — tabel biasa dengan border ===== */
        /* jelas per baris, BUKAN teks berpasangan menyamping yang bikin bingung bacanya. */
        table.mini-grid { width: 100%; border-collapse: collapse; margin: 6px 0 4px 0; border: 1px solid #e2e8f0; }
        table.mini-grid th { background: #F0F7FC; text-align: left; padding: 5px 10px; font-size: 8pt; color: #0B6FB4; border-bottom: 2px solid #d8e8f4; border-right: 1px solid #e2e8f0; }
        table.mini-grid th:last-child { border-right: none; text-align: right; }
        table.mini-grid td { padding: 5px 10px; font-size: 8.5pt; border-bottom: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; }
        table.mini-grid td:last-child { border-right: none; }
        table.mini-grid tr:nth-child(even) td { background: #fafbfc; }
        .mini-grid-label { color: #475569; }
        .mini-grid-value { color: #12233F; font-weight: bold; text-align: right; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        table.data-table th { background: #F0F7FC; text-align: left; padding: 6px 8px; font-size: 8.5pt; color: #0B6FB4; border-bottom: 2px solid #d8e8f4; }
        table.data-table td { padding: 5px 8px; font-size: 9pt; border-bottom: 1px solid #f1f5f9; }
        table.data-table tr:nth-child(even) { background: #fafbfc; }

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

    <div class="judul-laporan">Laporan Pengaduan Pelanggan</div>
    <div class="subjudul-laporan">Dicetak pada {{ \App\Models\Pengaduan::formatTanggalIndo(now(), true) }}</div>

    <div class="section">
        <table class="info-filter">
            <tr>
                <td><strong>Periode</strong><br>{{ \App\Models\Pengaduan::formatTanggalIndo($dari) }} s.d {{ \App\Models\Pengaduan::formatTanggalIndo($sampai) }}</td>
                <td><strong>Kategori</strong><br>{{ count($kategoriIds) > 0 ? $kategoriList->whereIn('id', $kategoriIds)->pluck('nama')->implode(', ') : 'Semua Kategori' }}</td>
                <td><strong>Status</strong><br>{{ count($statusFilterList) > 0 ? collect($statusFilterList)->map(fn ($s) => $labelStatus[$s] ?? $s)->implode(', ') : 'Semua Status' }}</td>
            </tr>
        </table>

        {{-- KPI --}}
        <table class="kpi-table">
            <tr>
                <td><div class="kpi-box"><div class="kpi-label">TOTAL PENGADUAN</div><div class="kpi-value">{{ $totalPengaduan }}</div></div></td>
                <td><div class="kpi-box"><div class="kpi-label">SELESAI</div><div class="kpi-value" style="color:#3FA75B">{{ $totalSelesai }}</div></div></td>
                <td><div class="kpi-box"><div class="kpi-label">DITOLAK</div><div class="kpi-value" style="color:#EF4444">{{ $totalDitolak }}</div></div></td>
                <td><div class="kpi-box"><div class="kpi-label">RATA-RATA SELESAI</div><div class="kpi-value" style="font-size:13pt">{{ $rataRataHariSelesai !== null ? $rataRataHariSelesai . ' hari' : '-' }}</div></div></td>
            </tr>
        </table>
    </div>

    {{-- Grafik tren + tabel titik data --}}
    <div class="section">
        <div class="judul-section">Tren Pengaduan Masuk ({{ $perBulan ? 'per Bulan' : 'per Hari' }})</div>
        @if ($trenChartImg)
            <img src="data:image/png;base64,{{ $trenChartImg }}" style="width: 100%; max-width: 480px; display: block; margin: 4px auto 8px auto;">
        @endif
        @if (count($trenLabel) > 0)
            <table class="mini-grid">
                <thead>
                    <tr><th>Tanggal</th><th>Jumlah Pengaduan</th></tr>
                </thead>
                <tbody>
                    @foreach ($trenLabel as $i => $label)
                        <tr>
                            <td class="mini-grid-label">{{ $label }}</td>
                            <td class="mini-grid-value">{{ $trenData[$i] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#94a3b8; font-size:9pt;">Tidak ada data pada periode ini.</p>
        @endif
    </div>

    {{-- Per kategori: 1 tabel gabungan (bar + jumlah + persen), gak ada duplikasi lagi --}}
    <div class="section">
        <div class="judul-section">Rekap per Kategori</div>
        <table class="rekap-table">
            <thead><tr><th>Kategori</th><th></th><th class="text-right">Jumlah</th><th class="text-right">%</th></tr></thead>
            <tbody>
                @php $maxKategori = $perKategori->max(); @endphp
                @forelse ($perKategori as $nama => $jumlah)
                    <tr>
                        <td class="rekap-label">{{ \Illuminate\Support\Str::limit($nama, 26) }}</td>
                        <td class="rekap-bar-cell">
                            <div class="rekap-bar-track">
                                <div class="rekap-bar-fill" style="width: {{ $maxKategori > 0 ? round($jumlah / $maxKategori * 100) : 0 }}%; background:{{ $warnaChart[$loop->index % count($warnaChart)] }};"></div>
                            </div>
                        </td>
                        <td class="rekap-jumlah">{{ $jumlah }}</td>
                        <td class="rekap-persen">{{ $totalPengaduan > 0 ? round($jumlah / $totalPengaduan * 100, 1) : 0 }}%</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center; color:#94a3b8;">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Per status: donat + legend gabungan (jumlah + persen sekaligus), gak ada tabel duplikat lagi --}}
    <div class="section">
        <div class="judul-section">Rekap per Status</div>
        @if ($statusChartImg)
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="width: 150px; vertical-align: middle;">
                        <img src="data:image/png;base64,{{ $statusChartImg }}" style="width: 140px; height: 140px;">
                    </td>
                    <td style="vertical-align: middle;">
                        @foreach ($perStatus as $nama => $jumlah)
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="width: 12px; padding: 3px 0;">
                                        <div style="width: 10px; height: 10px; background: {{ $warnaChart[$loop->index % count($warnaChart)] }}; border-radius: 2px;"></div>
                                    </td>
                                    <td style="font-size: 9pt; color: #334155; padding: 3px 6px;">{{ $nama }}</td>
                                    <td style="font-size: 9pt; font-weight: bold; text-align: right; color: #12233F; width:36px;">{{ $jumlah }}</td>
                                    <td style="font-size: 8pt; color: #94a3b8; text-align: right; width:44px;">({{ $totalPengaduan > 0 ? round($jumlah / $totalPengaduan * 100) : 0 }}%)</td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                </tr>
            </table>
        @else
            {{-- Fallback tabel biasa kalau GD gak aktif di server --}}
            <table class="rekap-table">
                <thead><tr><th>Status</th><th></th><th class="text-right">Jumlah</th><th class="text-right">%</th></tr></thead>
                <tbody>
                    @php $maxStatus = $perStatus->max(); @endphp
                    @forelse ($perStatus as $nama => $jumlah)
                        <tr>
                            <td class="rekap-label">{{ $nama }}</td>
                            <td class="rekap-bar-cell">
                                <div class="rekap-bar-track">
                                    <div class="rekap-bar-fill" style="width: {{ $maxStatus > 0 ? round($jumlah / $maxStatus * 100) : 0 }}%; background:{{ $warnaChart[$loop->index % count($warnaChart)] }};"></div>
                                </div>
                            </td>
                            <td class="rekap-jumlah">{{ $jumlah }}</td>
                            <td class="rekap-persen">{{ $totalPengaduan > 0 ? round($jumlah / $totalPengaduan * 100, 1) : 0 }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center; color:#94a3b8;">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    {{-- Detail pengaduan --}}
    <div class="judul-section">Detail Pengaduan ({{ $totalPengaduan }})</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nomor Pengaduan</th>
                <th>Tanggal Masuk</th>
                <th>Nama Pelapor</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarPengaduan as $item)
                <tr>
                    <td>{{ $item->kode_pengaduan }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $item->nama_pelapor }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($item->judul, 28) }}</td>
                    <td>{{ $item->statusLabel() }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center; color:#94a3b8;">Tidak ada pengaduan pada periode/filter ini</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        PERUMDA Tirtanadi Cabang Padang Bulan &middot; Laporan ini dibuat otomatis oleh sistem pengaduan pelanggan.
    </div>

</body>
</html>
