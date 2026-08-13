<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengaduan')->unique(); // PGD-20260806-00001

            // Data pelapor (diisi langsung di form, tanpa akun)
            $table->string('nama_pelapor');
            $table->string('no_pelanggan')->nullable(); // NPA, opsional kalau pelapor bukan pelanggan terdaftar
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->string('no_rumah_patokan')->nullable(); // patokan rumah/bangunan terdekat, memudahkan petugas cari lokasi

            // Detail pengaduan
            $table->foreignId('kategori_pengaduan_id')->constrained('kategori_pengaduans');
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('lokasi_kejadian')->nullable(); // titik/patokan lokasi kejadian, bisa beda dari alamat rumah
            $table->string('foto')->nullable(); // bukti foto awal dari pelapor

            // Penanganan
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['baru', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])
                  ->default('baru');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();

            // Pemeriksaan lapangan & SPKP (Surat Perintah Kerja Perbaikan)
            $table->text('hasil_pemeriksaan')->nullable(); // catatan petugas setelah cek lokasi
            $table->enum('perlu_spkp', ['ya', 'tidak'])->nullable(); // null = belum diperiksa
            $table->timestamp('tanggal_pemeriksaan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
