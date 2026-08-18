<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'hasil_pemeriksaan',
        'perlu_spkp',
        'tanggal_pemeriksaan',
    ];

    protected $casts = [
        'tanggal_selesai' => 'datetime',
        'tanggal_pemeriksaan' => 'datetime',
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

    public function statusLabel(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
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
            'diverifikasi' => '🟡',
            'diproses' => '🟠',
            'selesai' => '🟢',
            'ditolak' => '🔴',
            default => '⚪',
        };
    }
}
