<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pengaduan extends Model
{
    protected $fillable = [
        'kode_pengaduan',
        'nama_pelapor',
        'no_pelanggan',
        'no_hp',
        'email',
        'alamat',
        'no_rumah_patokan',
        'kategori_pengaduan_id',
        'judul',
        'deskripsi',
        'lokasi_kejadian',
        'petugas_id',
        'status',
        'catatan_admin',
        'tanggal_selesai',
        'catatan_selesai',
        'tanggal_ditolak',
        'jadwal_pengecekan',
        'tanggal_mulai_pengecekan',
        'petugas_pengecekan_nama',
        'tanggal_mulai_proses',
        'pelaksana_proses_nama',
        'hasil_pemeriksaan',
        'perlu_spkp',
        'tanggal_pemeriksaan',
        'tanggal_diverifikasi',
        'tanggapan_pengecekan_id',
        'rincian_biaya',
        'rincian_biaya_file',
        'rincian_biaya_file_nama_asli',
        'total_biaya',
        'status_persetujuan',
        'tanggal_persetujuan',
        'catatan_persetujuan',
        'bukti_pembayaran',
        'bukti_pembayaran_nama_asli',
        'catatan_verifikasi_pembayaran',
    ];

    protected $casts = [
        'tanggal_selesai' => 'datetime',
        'tanggal_ditolak' => 'datetime',
        'jadwal_pengecekan' => 'datetime',
        'tanggal_mulai_pengecekan' => 'datetime',
        'tanggal_mulai_proses' => 'datetime',
        'tanggal_pemeriksaan' => 'datetime',
        'tanggal_diverifikasi' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
        'total_biaya' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto generate kode_pengaduan: PGD-YYYYMMDD-00001
        static::creating(function ($pengaduan) {
            if (empty($pengaduan->kode_pengaduan)) {
                $tanggal = now()->format('Ymd');
                $urutan = static::whereDate('created_at', now()->toDateString())->count() + 1;
                $pengaduan->kode_pengaduan = 'PGD-' . $tanggal . '-' . str_pad($urutan, 5, '0', STR_PAD_LEFT);
            }
        });

        // Setiap pengaduan baru otomatis dapat entri pertama di timeline
        static::created(function ($pengaduan) {
            $pengaduan->tanggapans()->create([
                'user_id' => null,
                'pesan' => 'Pengaduan berhasil dikirim dan menunggu diverifikasi.',
                'status_baru' => 'baru',
            ]);
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function tanggapans()
    {
        return $this->hasMany(TanggapanPengaduan::class)->orderBy('created_at');
    }

    public function fotos()
    {
        return $this->hasMany(PengaduanFoto::class);
    }

    // Entri tanggapan yang berisi foto pengecekan (dari form Verifikasi), dipakai
    // sebagai lampiran di Surat Hasil Pengecekan.
    public function tanggapanPengecekan()
    {
        return $this->belongsTo(TanggapanPengaduan::class, 'tanggapan_pengecekan_id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'pengecekan' => 'Sedang Dicek',
            'menunggu_persetujuan' => 'Menunggu Persetujuan Pelanggan',
            'menunggu_verifikasi_pembayaran' => 'Verifikasi Pembayaran',
            'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'baru' => 'bg-blue-100 text-blue-700 border-blue-300',
            'pengecekan' => 'bg-violet-100 text-violet-700 border-violet-300',
            'menunggu_persetujuan' => 'bg-amber-100 text-amber-700 border-amber-300',
            'menunggu_verifikasi_pembayaran' => 'bg-cyan-100 text-cyan-700 border-cyan-300',
            'diverifikasi' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
            'diproses' => 'bg-orange-100 text-orange-700 border-orange-300',
            'selesai' => 'bg-green-100 text-green-700 border-green-300',
            'ditolak' => 'bg-red-100 text-red-700 border-red-300',
            default => 'bg-gray-100 text-gray-700 border-gray-300',
        };
    }

    // Label untuk kebutuhan SPKP (Surat Perintah Kerja Perbaikan)
    public function perluSpkpLabel(): string
    {
        return match ($this->perlu_spkp) {
            'ya' => 'Perlu SPKP',
            'tidak' => 'Tidak Perlu SPKP',
            default => 'Belum Diperiksa',
        };
    }

    /**
     * Update hasil pemeriksaan & keputusan SPKP, dan otomatis catat ke timeline.
     * Dipakai di Controller nanti — supaya setiap perubahan (termasuk koreksi) selalu
     * tercatat sebagai entri baru di tanggapan_pengaduans, bukan menimpa diam-diam.
     *
     * Contoh pemakaian di Controller:
     * $pengaduan->updatePemeriksaan('ya', 'Ditemukan kebocoran di pipa dinas', $petugasId);
     */
    public function updatePemeriksaan(string $perluSpkp, string $hasilPemeriksaan, ?int $userId = null): void
    {
        $sebelumnya = $this->perlu_spkp;

        $this->update([
            'perlu_spkp' => $perluSpkp,
            'hasil_pemeriksaan' => $hasilPemeriksaan,
            'tanggal_pemeriksaan' => now(),
        ]);

        $pesan = is_null($sebelumnya)
            ? 'Hasil pemeriksaan: ' . $hasilPemeriksaan . ' (' . $this->perluSpkpLabel() . ')'
            : 'Hasil pemeriksaan diperbarui: semula "' . match ($sebelumnya) {
                'ya' => 'Perlu SPKP', 'tidak' => 'Tidak Perlu SPKP', default => 'Belum Diperiksa',
              } . '", diubah menjadi "' . $this->perluSpkpLabel() . '". ' . $hasilPemeriksaan;

        $this->tanggapans()->create([
            'user_id' => $userId,
            'pesan' => $pesan,
        ]);
    }

    // Emoji bulat untuk timeline (sesuai contoh mockup)
    public function statusDot(): string
    {
        return match ($this->status) {
            'baru' => '🟢',
            'pengecekan' => '🟣',
            'menunggu_persetujuan' => '🟠',
            'menunggu_verifikasi_pembayaran' => '🔵',
            'diverifikasi' => '🟡',
            'diproses' => '🟠',
            'selesai' => '🟢',
            'ditolak' => '🔴',
            default => '⚪',
        };
    }

    // True kalau pengaduan ini sedang menunggu pelanggan menyetujui/menolak biaya penanganan
    public function butuhPersetujuan(): bool
    {
        return $this->status === 'menunggu_persetujuan';
    }

    // True kalau pelanggan sudah setuju & upload bukti bayar, tapi admin belum verifikasi
    public function menungguVerifikasiPembayaran(): bool
    {
        return $this->status === 'menunggu_verifikasi_pembayaran';
    }

    // Format rupiah untuk ditampilkan, contoh: Rp 150.000
    public function formattedTotalBiaya(): ?string
    {
        if (is_null($this->total_biaya)) {
            return null;
        }

        return self::formatRupiah((float) $this->total_biaya);
    }

    // Static & generik (gak terikat ke 1 pengaduan) -- dipakai buat laporan keuangan
    // yang perlu format rupiah dari angka hasil SUM/rata-rata, bukan dari 1 record.
    public static function formatRupiah(float $angka): string
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | LAMA MENUNGGU (dipakai Laporan Tunggakan)
    |--------------------------------------------------------------------------
    | Catatan penting: Carbon 3 (versi yang dipakai project ini) mengubah default
    | diffInDays()/diffInHours() jadi mengembalikan angka desimal presisi (misal
    | 2.5517570863079), BEDA dari Carbon 2 yang otomatis bulat. Makanya di sini
    | HARUS dibulatkan eksplisit pakai round(), bukan cuma soal format tampilan.
    |--------------------------------------------------------------------------
    */
    public static function jamMenunggu(\DateTimeInterface $sejak): int
    {
        return (int) round(Carbon::parse($sejak)->diffInHours(now()));
    }

    public static function hariMenunggu(\DateTimeInterface $sejak): int
    {
        return (int) round(self::jamMenunggu($sejak) / 24);
    }

    // Contoh hasil: "24 jam (1 hari)"
    public static function formatLamaMenunggu(\DateTimeInterface $sejak): string
    {
        $jam = self::jamMenunggu($sejak);
        $hari = self::hariMenunggu($sejak);

        return "{$jam} jam ({$hari} hari)";
    }

    // URL dokumen rincian biaya (Word/Excel/PDF yang diupload admin)
    public function rincianBiayaFileUrl(): ?string
    {
        return $this->rincian_biaya_file ? '/storage/' . $this->rincian_biaya_file : null;
    }

    public function rincianBiayaFileExt(): ?string
    {
        return $this->rincian_biaya_file ? strtolower(pathinfo($this->rincian_biaya_file, PATHINFO_EXTENSION)) : null;
    }

    // Ikon sederhana berdasarkan tipe file, buat ditampilkan di tombol download
    public function rincianBiayaFileIcon(): string
    {
        return match ($this->rincianBiayaFileExt()) {
            'doc', 'docx' => '📄',
            'xls', 'xlsx' => '📊',
            'pdf' => '📕',
            default => '📎',
        };
    }

    // URL bukti pembayaran yang diupload pelanggan
    public function buktiPembayaranUrl(): ?string
    {
        return $this->bukti_pembayaran ? '/storage/' . $this->bukti_pembayaran : null;
    }

    public function buktiPembayaranExt(): ?string
    {
        return $this->bukti_pembayaran ? strtolower(pathinfo($this->bukti_pembayaran, PATHINFO_EXTENSION)) : null;
    }

    public function buktiPembayaranIsGambar(): bool
    {
        return in_array($this->buktiPembayaranExt(), ['jpg', 'jpeg', 'png']);
    }

    /*
    |--------------------------------------------------------------------------
    | SURAT PEMBERITAHUAN PER TAHAP STATUS
    |--------------------------------------------------------------------------
    | Dipakai controller & view surat buat nentuin surat mana yang udah bisa
    | dilihat/didownload pelanggan. Sengaja dicek dari data historisnya
    | (bukan status SAAT INI), supaya pelanggan tetap bisa buka surat lama
    | walau pengaduannya udah lanjut ke tahap berikutnya.
    |--------------------------------------------------------------------------
    */
    public function suratTersedia(string $jenis): bool
    {
        return match ($jenis) {
            'pengecekan' => !is_null($this->jadwal_pengecekan),
            'hasil_pengecekan' => !is_null($this->tanggal_pemeriksaan),
            'verifikasi_pengaduan' => !is_null($this->tanggal_diverifikasi),
            'proses' => !is_null($this->pelaksana_proses_nama),
            'selesai' => $this->status === 'selesai',
            'ditolak' => $this->status === 'ditolak',
            default => false,
        };
    }

    // Daftar jenis surat status yang sudah tersedia, urut sesuai alur (buat ditampilkan di Lacak Pengaduan)
    public function daftarSuratStatusTersedia(): array
    {
        $label = [
            'pengecekan' => 'Surat Pemberitahuan Pengecekan',
            'hasil_pengecekan' => 'Surat Hasil Pengecekan',
            'verifikasi_pengaduan' => 'Surat Verifikasi Pengaduan',
            'proses' => 'Surat Pemberitahuan Proses Penanganan',
            'selesai' => 'Surat Keterangan Selesai',
            'ditolak' => 'Surat Pemberitahuan Penolakan',
        ];

        $tersedia = [];
        foreach ($label as $jenis => $nama) {
            if ($this->suratTersedia($jenis)) {
                $tersedia[$jenis] = $nama;
            }
        }

        return $tersedia;
    }

    // Nama surat (label) untuk 1 jenis tertentu — dipakai buat link surat di timeline
    public function namaSurat(string $jenis): ?string
    {
        return match ($jenis) {
            'pengecekan' => 'Surat Pemberitahuan Pengecekan',
            'hasil_pengecekan' => 'Surat Hasil Pengecekan',
            'verifikasi_pengaduan' => 'Surat Verifikasi Pengaduan',
            'proses' => 'Surat Pemberitahuan Proses Penanganan',
            'selesai' => 'Surat Keterangan Selesai',
            'ditolak' => 'Surat Pemberitahuan Penolakan',
            default => null,
        };
    }

    // True kalau penolakan diinisiasi ADMIN (waktu pengecekan). False kalau pelanggan
    // sendiri yang membatalkan (menolak biaya penanganan yang diajukan). Sengaja dicek dari
    // status_persetujuan, BUKAN dari catatan_admin -- soalnya catatan_admin ternyata
    // ke-isi di kedua jalur (admin tolak & pelanggan batalkan), jadi gak bisa dipakai
    // buat membedakan sumber penolakannya.
    public function ditolakOlehAdmin(): bool
    {
        return $this->status === 'ditolak' && $this->status_persetujuan !== 'ditolak';
    }

    // Alasan penolakan, dari sumber manapun asalnya (admin atau pelanggan)
    public function alasanPenolakan(): ?string
    {
        if ($this->ditolakOlehAdmin()) {
            return $this->catatan_admin;
        }

        return $this->catatan_persetujuan ?: 'Tidak menyetujui biaya yang diajukan.';
    }

    // Bikin nama file upload yang rapi & terstruktur (bukan nama acak),
    // contoh hasil: "Rincian-Biaya-Budi-Santoso-PGD-20260825-00006.pdf"
    public static function namaFileUpload(string $prefix, string $namaPelapor, string $kodePengaduan, string $ekstensi): string
    {
        $slugNama = \Illuminate\Support\Str::slug($namaPelapor);

        return "{$prefix}-{$slugNama}-{$kodePengaduan}.{$ekstensi}";
    }

    // Format tanggal ke Bahasa Indonesia manual (gak gantung locale app yang defaultnya 'en')
    public static function formatTanggalIndo(?\DateTimeInterface $tanggal, bool $denganJam = false): string
    {
        if (is_null($tanggal)) {
            return '-';
        }

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $hasil = $tanggal->format('d') . ' ' . $bulanIndo[(int) $tanggal->format('n')] . ' ' . $tanggal->format('Y');

        if ($denganJam) {
            $hasil .= ', ' . $tanggal->format('H:i') . ' WIB';
        }

        return $hasil;
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI WHATSAPP (via link wa.me — gratis, tanpa API berbayar)
    |--------------------------------------------------------------------------
    | Membuka WhatsApp dengan nomor pelanggan & pesan yang sudah terisi otomatis.
    | Admin tinggal review sekilas lalu klik kirim di WhatsApp. Ini BUKAN kirim
    | otomatis dari server (itu butuh WhatsApp Business API / gateway berbayar),
    | tapi cukup buat kebutuhan notifikasi manual yang cepat & tanpa biaya.
    |--------------------------------------------------------------------------
    */

    // Normalisasi nomor HP pelanggan ke format wa.me (62xxxxxxxxxx, tanpa + / spasi / strip)
    public function nomorWhatsapp(): ?string
    {
        $nomor = preg_replace('/\D/', '', (string) $this->no_hp);

        if ($nomor === '') {
            return null;
        }

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (!str_starts_with($nomor, '62')) {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    // Isi pesan WhatsApp, disesuaikan per jenis surat & kondisi (ada biaya / gratis / ditolak)
    public function pesanWhatsapp(string $jenis): ?string
    {
        if (!$this->suratTersedia($jenis)) {
            return null;
        }

        $kategori = $this->kategori->nama ?? 'pengaduan Anda';
        $adaBiaya = !is_null($this->total_biaya) && (float) $this->total_biaya > 0;

        // ===== DISCLAIMER PROJECT (paling atas, sebelum pembuka resmi) =====
        // Sistem ini masih tugas/project, BUKAN sistem resmi PDAM Tirtanadi yang
        // sungguhan dipakai publik. Disclaimer ini WAJIB ada supaya kalau pesan ini
        // ke-kirim ke nomor yang salah, penerimanya gak salah paham dan menganggap
        // ini pesan resmi dari perusahaan.
        // Sengaja TANPA emoji (mis. ⚠️) karena beberapa emoji bisa tampil sebagai
        // kotak/karakter aneh di WhatsApp Web tergantung encoding perangkat --
        // dipakai *tebal* + huruf kapital biar tetap mencolok tanpa emoji.
        $disclaimer = "*[PESAN DEMO/TUGAS PROJECT - BUKAN PESAN RESMI PDAM TIRTANADI]*"
            . "\n_Mohon abaikan jika Anda menerima pesan ini secara tidak sengaja._";

        // ===== PEMBUKA (sama untuk semua jenis surat) =====
        $pembuka = "Yth. Bapak/Ibu *{$this->nama_pelapor}*,"
            . "\n\nKami dari *PERUMDA Tirtanadi Cabang Padang Bulan* ingin menyampaikan informasi terbaru mengenai pengaduan Anda (No. *{$this->kode_pengaduan}*) perihal *{$kategori}*.";

        // ===== ISI (beda per jenis & kondisi) — bahasa dibuat general, bukan cuma soal "perbaikan", =====
        // ===== supaya tetap pas dipakai untuk kategori pengaduan apapun (bukan cuma kerusakan fisik). =====
        $isi = match ($jenis) {
            'pengecekan' => 'Pengaduan Anda akan segera kami tindak lanjuti dengan pengecekan langsung ke lokasi oleh petugas kami pada *'
                . self::formatTanggalIndo($this->jadwal_pengecekan, true)
                . '*. Kami mohon kesediaan Bapak/Ibu untuk dapat ditemui di lokasi pada jadwal tersebut.',

            'hasil_pengecekan' => $adaBiaya
                ? 'Pengecekan lapangan atas pengaduan Anda telah selesai kami lakukan. Berdasarkan hasil pemeriksaan, diperlukan tindak lanjut dengan biaya sebesar *' . $this->formattedTotalBiaya() . '*. Rincian biaya dapat Bapak/Ibu lihat pada dokumen yang tercantum di bawah ini. Mohon kesediaan Bapak/Ibu untuk memberikan persetujuan agar pengaduan ini dapat segera kami lanjutkan.'
                : 'Pengecekan lapangan atas pengaduan Anda telah selesai kami lakukan. Pengaduan ini *tidak dikenakan biaya apapun*, dan akan segera kami lanjutkan ke tahap berikutnya.',

            'verifikasi_pengaduan' => $adaBiaya
                ? 'Pembayaran sebesar *' . $this->formattedTotalBiaya() . '* untuk pengaduan Anda telah kami terima dan verifikasi. Pengaduan Anda akan segera kami lanjutkan ke tahap berikutnya.'
                : 'Pengaduan Anda telah *terverifikasi* dan akan segera kami lanjutkan ke tahap berikutnya.',

            'proses' => "Pengaduan Anda sudah *mulai kami tindak lanjuti* oleh petugas kami, {$this->pelaksana_proses_nama}.",

            'selesai' => 'Pengaduan Anda telah *SELESAI* kami tangani dan tindak lanjuti sepenuhnya. Terima kasih atas kesabaran Bapak/Ibu selama proses penanganan berlangsung.',

            'ditolak' => $this->ditolakOlehAdmin()
                ? "Mohon maaf, setelah kami tinjau lebih lanjut, pengaduan Anda *belum dapat kami lanjutkan* dengan keterangan sebagai berikut:\n\"" . $this->alasanPenolakan() . '"' . "\n\nApabila Bapak/Ibu memerlukan informasi lebih lanjut, silakan hubungi layanan pelanggan kami."
                : "Kami informasikan bahwa pengaduan Anda telah *dibatalkan* sesuai permintaan Bapak/Ibu, dengan keterangan sebagai berikut:\n\"" . $this->alasanPenolakan() . '"' . "\n\nApabila sewaktu-waktu Bapak/Ibu ingin mengajukan pengaduan kembali, kami siap membantu.",

            default => null,
        };

        if (is_null($isi)) {
            return null;
        }

        // ===== BLOK LINK: surat (selalu), dokumen pendukung (kondisional), lacak (selalu) =====
        // Ditulis sebagai daftar bernomor rapi, tanpa emoji, biar kesannya formal/profesional.
        $baseUrl = request()->root();
        $linkSurat = $baseUrl . '/pengaduan/' . $this->kode_pengaduan . '/surat/' . $jenis;
        $linkLacak = $baseUrl . '/lacak?kode=' . $this->kode_pengaduan;

        $daftarLink = ['Surat Pemberitahuan: ' . $linkSurat];

        if ($jenis === 'hasil_pengecekan' && $adaBiaya && $this->rincianBiayaFileUrl()) {
            $daftarLink[] = 'Dokumen Rincian Biaya: ' . $baseUrl . $this->rincianBiayaFileUrl();
        } elseif ($jenis === 'verifikasi_pengaduan' && $adaBiaya && $this->buktiPembayaranUrl()) {
            $daftarLink[] = 'Bukti Pembayaran: ' . $baseUrl . $this->buktiPembayaranUrl();
        }

        $daftarLink[] = 'Lacak Pengaduan Anda: ' . $linkLacak;

        $blokLink = "Berikut kami lampirkan tautan terkait:\n";
        foreach ($daftarLink as $i => $baris) {
            $blokLink .= ($i + 1) . '. ' . $baris . "\n";
        }
        $blokLink = rtrim($blokLink);

        // ===== PENUTUP (sama untuk semua jenis surat) =====
        $penutup = 'Demikian informasi yang dapat kami sampaikan. Atas perhatian dan kepercayaan Bapak/Ibu kepada kami, kami ucapkan terima kasih.'
            . "\n\nHormat kami,\n*PERUMDA Tirtanadi Cabang Padang Bulan*";

        return "{$disclaimer}\n\n{$pembuka}\n\n{$isi}\n\n{$blokLink}\n\n{$penutup}";
    }

    // Link wa.me siap-klik: buka WhatsApp dengan nomor & pesan yang sudah terisi otomatis
    public function linkWhatsapp(string $jenis): ?string
    {
        $nomor = $this->nomorWhatsapp();
        $pesan = $this->pesanWhatsapp($jenis);

        if (!$nomor || !$pesan) {
            return null;
        }

        return 'https://wa.me/' . $nomor . '?text=' . urlencode($pesan);
    }
}
