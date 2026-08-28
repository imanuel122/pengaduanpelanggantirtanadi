<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use App\Support\ChartImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->dataLaporan($request);

        return view('dashboard.laporan.index', $data);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->dataLaporan($request, sertakanGambarChart: true);

        $pdf = Pdf::loadView('dashboard.laporan.pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Pengaduan-' . $data['dari']->format('Ymd') . '-' . $data['sampai']->format('Ymd') . '.pdf');
    }

    public function keuangan(Request $request)
    {
        $data = $this->dataKeuangan($request);

        return view('dashboard.laporan.keuangan', $data);
    }

    public function keuanganExportPdf(Request $request)
    {
        $data = $this->dataKeuangan($request, sertakanGambarChart: true);

        $pdf = Pdf::loadView('dashboard.laporan.keuangan-pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Keuangan-' . $data['dari']->format('Ymd') . '-' . $data['sampai']->format('Ymd') . '.pdf');
    }

    public function keuanganExportCsv(Request $request)
    {
        $data = $this->dataKeuangan($request);

        $namaFile = 'Data-Keuangan-' . $data['dari']->format('Ymd') . '-' . $data['sampai']->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $kolom = ['Nomor Pengaduan', 'Tanggal Pembayaran', 'Nama Pelanggan', 'No. HP', 'Kategori', 'Nominal (Rp)'];

        return response()->stream(function () use ($data, $kolom) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $kolom);

            foreach ($data['transaksi'] as $t) {
                fputcsv($out, [
                    $t->kode_pengaduan,
                    $t->tanggal_persetujuan?->format('d-m-Y H:i'),
                    $t->nama_pelapor,
                    $t->no_hp,
                    $t->kategori->nama ?? '-',
                    (float) $t->total_biaya,
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    public function tunggakan(Request $request)
    {
        $data = $this->dataTunggakan($request);

        return view('dashboard.laporan.tunggakan', $data);
    }

    public function tunggakanExportPdf(Request $request)
    {
        $data = $this->dataTunggakan($request);

        $pdf = Pdf::loadView('dashboard.laporan.tunggakan-pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Tunggakan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function tunggakanExportCsv(Request $request)
    {
        $data = $this->dataTunggakan($request);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Data-Tunggakan-' . now()->format('Ymd-His') . '.csv"',
        ];

        $kolom = ['Nomor Pengaduan', 'Nama Pelanggan', 'No. HP', 'Kategori', 'Status', 'Nominal (Rp)', 'Sejak Tanggal', 'Lama Menunggu (Jam)', 'Lama Menunggu (Hari)'];

        return response()->stream(function () use ($data, $kolom) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $kolom);

            foreach ($data['daftar'] as $p) {
                fputcsv($out, [
                    $p->kode_pengaduan,
                    $p->nama_pelapor,
                    $p->no_hp,
                    $p->kategori->nama ?? '-',
                    $p->statusLabel(),
                    (float) $p->total_biaya,
                    $p->tanggal_pemeriksaan?->format('d-m-Y H:i'),
                    $p->tanggal_pemeriksaan ? Pengaduan::jamMenunggu($p->tanggal_pemeriksaan) : '-',
                    $p->tanggal_pemeriksaan ? Pengaduan::hariMenunggu($p->tanggal_pemeriksaan) : '-',
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    public function exportCsv(Request $request)
    {
        $data = $this->dataLaporan($request);

        $namaFile = 'Data-Pengaduan-' . $data['dari']->format('Ymd') . '-' . $data['sampai']->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ];

        $kolom = [
            'Nomor Pengaduan', 'Tanggal Masuk', 'Nama Pelapor', 'No. HP', 'Kategori',
            'Judul', 'Status', 'Total Biaya', 'Tanggal Selesai',
        ];

        return response()->stream(function () use ($data, $kolom) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM, biar Excel baca UTF-8 (huruf ó, é dsb) dengan benar
            fputcsv($out, $kolom);

            foreach ($data['daftarPengaduan'] as $p) {
                fputcsv($out, [
                    $p->kode_pengaduan,
                    $p->created_at->format('d-m-Y H:i'),
                    $p->nama_pelapor,
                    $p->no_hp,
                    $p->kategori->nama ?? '-',
                    $p->judul,
                    $p->statusLabel(),
                    $p->total_biaya ? $p->formattedTotalBiaya() : '-',
                    $p->tanggal_selesai ? $p->tanggal_selesai->format('d-m-Y H:i') : '-',
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    // Semua logika filter & hitung-hitungan laporan, dipakai bareng oleh index/exportPdf/exportCsv
    // supaya angka yang ditampilkan di layar, PDF, dan CSV selalu konsisten sama persis.
    private function dataLaporan(Request $request, bool $sertakanGambarChart = false): array
    {
        $dari = $request->filled('dari')
            ? Carbon::parse($request->query('dari'))->startOfDay()
            : now()->startOfMonth();
        $sampai = $request->filled('sampai')
            ? Carbon::parse($request->query('sampai'))->endOfDay()
            : now()->endOfDay();

        // Jaga-jaga kalau "dari" ternyata lebih besar dari "sampai" (input rentang kebalik)
        if ($dari->greaterThan($sampai)) {
            [$dari, $sampai] = [$sampai->copy()->startOfDay(), $dari->copy()->endOfDay()];
        }

        // Multi-select: bisa pilih beberapa kategori/status sekaligus, atau kosongkan semua = "Semua"
        $kategoriIds = array_values(array_filter((array) $request->query('kategori_id', [])));
        $statusFilterList = array_values(array_filter((array) $request->query('status', [])));

        $query = Pengaduan::with('kategori')
            ->whereBetween('created_at', [$dari, $sampai])
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds))
            ->when(count($statusFilterList) > 0, fn ($q) => $q->whereIn('status', $statusFilterList));

        $daftarPengaduan = (clone $query)->latest()->get();
        $totalPengaduan = $daftarPengaduan->count();

        $selesai = $daftarPengaduan->where('status', 'selesai');
        $totalSelesai = $selesai->count();
        $totalDitolak = $daftarPengaduan->where('status', 'ditolak')->count();
        $totalDalamProses = $totalPengaduan - $totalSelesai - $totalDitolak;

        // Rata-rata lama penyelesaian (dari pengaduan masuk s/d dinyatakan selesai), dalam hari
        $rataRataHariSelesai = $selesai->isNotEmpty()
            ? round($selesai->avg(fn ($p) => $p->created_at->diffInHours($p->tanggal_selesai) / 24), 1)
            : null;

        // Breakdown per kategori
        $perKategori = $daftarPengaduan->groupBy(fn ($p) => $p->kategori->nama ?? 'Tanpa Kategori')
            ->map->count()
            ->sortDesc();

        // Breakdown per status
        $labelStatus = [
            'baru' => 'Baru', 'pengecekan' => 'Pengecekan', 'menunggu_persetujuan' => 'Menunggu Persetujuan',
            'menunggu_verifikasi_pembayaran' => 'Verifikasi Pembayaran', 'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak',
        ];
        $perStatus = $daftarPengaduan->groupBy('status')
            ->map->count()
            ->mapWithKeys(fn ($jumlah, $status) => [($labelStatus[$status] ?? $status) => $jumlah]);

        // Tren harian/bulanan -- kalau rentangnya panjang (>62 hari), kelompokkan per bulan
        // biar grafiknya gak penuh sesak sama titik data harian.
        // Sengaja pakai DB::table() murni (bukan clone $query yang ada with('kategori')),
        // soalnya selectRaw()+groupBy() bentrok kalau masih nyoba eager-load relasi di atasnya.
        $jumlahHari = $dari->diffInDays($sampai) + 1;
        $perBulan = $jumlahHari > 62;
        $format = $perBulan ? '%Y-%m' : '%Y-%m-%d';

        $trenMentah = DB::table('pengaduans')
            ->whereBetween('created_at', [$dari, $sampai])
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds))
            ->when(count($statusFilterList) > 0, fn ($q) => $q->whereIn('status', $statusFilterList))
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as periode, COUNT(*) as jumlah")
            ->groupBy('periode')
            ->orderBy('periode')
            ->pluck('jumlah', 'periode');

        $trenLabel = [];
        $trenData = [];
        foreach ($trenMentah as $periode => $jumlah) {
            $trenLabel[] = $perBulan
                ? Carbon::createFromFormat('Y-m', $periode)->translatedFormat('M Y')
                : Carbon::parse($periode)->translatedFormat('d M');
            $trenData[] = $jumlah;
        }

        // Palet warna dipakai bareng buat grafik kategori (bar CSS) & status (donat GD) --
        // biar warnanya konsisten sama yang di halaman web.
        $warnaChart = ['#0B6FB4', '#14958C', '#3FA75B', '#8CC63F', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'];

        // Grafik buat PDF -- digambar server-side pakai GD (lihat komentar di ChartImage).
        // Cuma digenerate kalau memang mau dipakai PDF, biar halaman web gak buang resource
        // gambar gambar yang gak dipakai (soalnya web sudah pakai Chart.js sendiri).
        $trenChartImg = $sertakanGambarChart ? ChartImage::garis($trenLabel, $trenData) : null;
        $statusChartImg = $sertakanGambarChart ? ChartImage::donat($perStatus->values()->all(), $warnaChart) : null;

        return [
            'dari' => $dari,
            'sampai' => $sampai,
            'kategoriIds' => $kategoriIds,
            'statusFilterList' => $statusFilterList,
            'kategoriList' => KategoriPengaduan::orderBy('nama')->get(),
            'labelStatus' => $labelStatus,
            'daftarPengaduan' => $daftarPengaduan,
            'totalPengaduan' => $totalPengaduan,
            'totalSelesai' => $totalSelesai,
            'totalDitolak' => $totalDitolak,
            'totalDalamProses' => $totalDalamProses,
            'rataRataHariSelesai' => $rataRataHariSelesai,
            'perKategori' => $perKategori,
            'perStatus' => $perStatus,
            'trenLabel' => $trenLabel,
            'trenData' => $trenData,
            'perBulan' => $perBulan,
            'warnaChart' => $warnaChart,
            'trenChartImg' => $trenChartImg,
            'statusChartImg' => $statusChartImg,
        ];
    }

    // Logika filter & hitung-hitungan Laporan Keuangan, dipakai bareng oleh
    // keuangan/keuanganExportPdf/keuanganExportCsv.
    //
    // Beda penting sama Laporan Pengaduan: yang dihitung di sini cuma pengaduan yang
    // BENERAN ada transaksi pembayarannya (status_persetujuan = disetujui & total_biaya > 0),
    // dan difilter berdasarkan TANGGAL PEMBAYARAN (tanggal_persetujuan) -- bukan tanggal
    // pengaduan masuk -- karena yang relevan buat laporan keuangan adalah kapan uangnya
    // benar-benar diterima, bukan kapan keluhannya pertama kali dilaporkan.
    private function dataKeuangan(Request $request, bool $sertakanGambarChart = false): array
    {
        $dari = $request->filled('dari')
            ? Carbon::parse($request->query('dari'))->startOfDay()
            : now()->startOfMonth();
        $sampai = $request->filled('sampai')
            ? Carbon::parse($request->query('sampai'))->endOfDay()
            : now()->endOfDay();

        if ($dari->greaterThan($sampai)) {
            [$dari, $sampai] = [$sampai->copy()->startOfDay(), $dari->copy()->endOfDay()];
        }

        $kategoriIds = array_values(array_filter((array) $request->query('kategori_id', [])));

        $query = Pengaduan::with('kategori')
            ->where('status_persetujuan', 'disetujui')
            ->whereNotNull('total_biaya')
            ->where('total_biaya', '>', 0)
            ->whereBetween('tanggal_persetujuan', [$dari, $sampai])
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds));

        $transaksi = (clone $query)->orderByDesc('tanggal_persetujuan')->get();

        $totalPemasukan = (float) $transaksi->sum('total_biaya');
        $jumlahTransaksi = $transaksi->count();
        $rataRataTransaksi = $jumlahTransaksi > 0 ? $totalPemasukan / $jumlahTransaksi : 0;

        $perKategori = $transaksi->groupBy(fn ($p) => $p->kategori->nama ?? 'Tanpa Kategori')
            ->map(fn ($grup) => (float) $grup->sum('total_biaya'))
            ->sortDesc();

        $kategoriTerbesar = $perKategori->keys()->first();

        // Pengaduan berbayar yang DITOLAK/DIBATALKAN pelanggan (bukan ditolak admin) --
        // ini "potensi pendapatan yang hilang", pelengkap Total Pemasukan biar kelihatan
        // gambaran penuh: dari total yang diajukan, berapa beneran masuk vs berapa batal.
        // Difilter pakai tanggal_ditolak (kapan keputusan itu terjadi), konsisten sama
        // Total Pemasukan yang pakai tanggal_persetujuan (kapan pembayaran terjadi).
        $ditolak = Pengaduan::with('kategori')
            ->where('status_persetujuan', 'ditolak')
            ->whereNotNull('total_biaya')
            ->where('total_biaya', '>', 0)
            ->whereBetween('tanggal_ditolak', [$dari, $sampai])
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds))
            ->orderByDesc('tanggal_ditolak')
            ->get();

        $totalPendapatanHilang = (float) $ditolak->sum('total_biaya');
        $jumlahDitolak = $ditolak->count();

        // Tren pemasukan per hari/bulan (nominal Rupiah, bukan jumlah transaksi)
        $jumlahHari = $dari->diffInDays($sampai) + 1;
        $perBulan = $jumlahHari > 62;
        $format = $perBulan ? '%Y-%m' : '%Y-%m-%d';

        $trenMentah = DB::table('pengaduans')
            ->where('status_persetujuan', 'disetujui')
            ->whereNotNull('total_biaya')
            ->where('total_biaya', '>', 0)
            ->whereBetween('tanggal_persetujuan', [$dari, $sampai])
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds))
            ->selectRaw("DATE_FORMAT(tanggal_persetujuan, '{$format}') as periode, SUM(total_biaya) as total")
            ->groupBy('periode')
            ->orderBy('periode')
            ->pluck('total', 'periode');

        $trenLabel = [];
        $trenData = [];
        foreach ($trenMentah as $periode => $total) {
            $trenLabel[] = $perBulan
                ? Carbon::createFromFormat('Y-m', $periode)->translatedFormat('M Y')
                : Carbon::parse($periode)->translatedFormat('d M');
            $trenData[] = (float) $total;
        }

        $warnaChart = ['#0B6FB4', '#14958C', '#3FA75B', '#8CC63F', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'];
        $trenChartImg = $sertakanGambarChart ? ChartImage::garis($trenLabel, $trenData) : null;

        return [
            'dari' => $dari,
            'sampai' => $sampai,
            'kategoriIds' => $kategoriIds,
            'kategoriList' => KategoriPengaduan::orderBy('nama')->get(),
            'transaksi' => $transaksi,
            'totalPemasukan' => $totalPemasukan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'rataRataTransaksi' => $rataRataTransaksi,
            'perKategori' => $perKategori,
            'kategoriTerbesar' => $kategoriTerbesar,
            'ditolak' => $ditolak,
            'totalPendapatanHilang' => $totalPendapatanHilang,
            'jumlahDitolak' => $jumlahDitolak,
            'trenLabel' => $trenLabel,
            'trenData' => $trenData,
            'perBulan' => $perBulan,
            'warnaChart' => $warnaChart,
            'trenChartImg' => $trenChartImg,
        ];
    }

    // Data buat Laporan Tunggakan: pengaduan yang udah ada tagihan biaya tapi belum lunas.
    // Ada 2 kondisi "belum lunas" di sistem ini:
    // 1. menunggu_persetujuan          -> pelanggan belum merespon/bayar sama sekali
    // 2. menunggu_verifikasi_pembayaran -> pelanggan udah bayar & upload bukti, tapi admin
    //                                      belum verifikasi (jadi belum tercatat resmi sbg pemasukan)
    //
    // Sengaja TANPA filter rentang tanggal -- ini laporan kondisi SAAT INI ("berapa yang
    // masih outstanding sekarang"), bukan laporan historis periode tertentu.
    private function dataTunggakan(Request $request): array
    {
        $kategoriIds = array_values(array_filter((array) $request->query('kategori_id', [])));

        $query = Pengaduan::with('kategori')
            ->whereIn('status', ['menunggu_persetujuan', 'menunggu_verifikasi_pembayaran'])
            ->whereNotNull('total_biaya')
            ->where('total_biaya', '>', 0)
            ->when(count($kategoriIds) > 0, fn ($q) => $q->whereIn('kategori_pengaduan_id', $kategoriIds));

        $daftar = (clone $query)->orderBy('tanggal_pemeriksaan')->get();

        $totalTunggakan = (float) $daftar->sum('total_biaya');
        $jumlahTunggakan = $daftar->count();

        $menungguPersetujuan = $daftar->where('status', 'menunggu_persetujuan');
        $menungguVerifikasi = $daftar->where('status', 'menunggu_verifikasi_pembayaran');

        return [
            'kategoriIds' => $kategoriIds,
            'kategoriList' => KategoriPengaduan::orderBy('nama')->get(),
            'daftar' => $daftar,
            'totalTunggakan' => $totalTunggakan,
            'jumlahTunggakan' => $jumlahTunggakan,
            'jumlahMenungguPersetujuan' => $menungguPersetujuan->count(),
            'totalMenungguPersetujuan' => (float) $menungguPersetujuan->sum('total_biaya'),
            'jumlahMenungguVerifikasi' => $menungguVerifikasi->count(),
            'totalMenungguVerifikasi' => (float) $menungguVerifikasi->sum('total_biaya'),
        ];
    }
}
