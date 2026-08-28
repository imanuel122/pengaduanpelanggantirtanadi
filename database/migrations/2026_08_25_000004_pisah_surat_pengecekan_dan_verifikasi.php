<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Kapan pengaduan resmi masuk status 'diverifikasi' -- baik langsung (gratis, tanpa
            // perlu persetujuan biaya) maupun setelah admin verifikasi bukti pembayaran.
            // Dipakai sebagai penanda ketersediaan + tanggal Surat Verifikasi Pengaduan.
            $table->dateTime('tanggal_diverifikasi')->nullable()->after('tanggal_pemeriksaan');

            // Referensi ke entri tanggapan yang berisi foto pengecekan (dari form Verifikasi),
            // dipakai untuk lampiran foto di Surat Hasil Pengecekan. Sengaja tanpa foreign key
            // constraint supaya urutan migrasi antar tabel gak saling bergantung.
            $table->unsignedBigInteger('tanggapan_pengecekan_id')->nullable()->after('tanggal_diverifikasi');
        });

        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            // Penanda entri timeline ini berkaitan dengan penerbitan surat apa, dipakai untuk
            // nampilin link "Lihat Surat" langsung di baris timeline yang relevan.
            $table->string('jenis_surat')->nullable()->after('status_baru');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_diverifikasi', 'tanggapan_pengecekan_id']);
        });

        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            $table->dropColumn('jenis_surat');
        });
    }
};
