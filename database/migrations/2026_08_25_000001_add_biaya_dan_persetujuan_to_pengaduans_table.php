<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah status 'menunggu_persetujuan' ke enum. Posisinya di antara
        // 'pengecekan' dan 'diverifikasi' — dipakai saat hasil pengecekan
        // menemukan ada biaya perbaikan yang perlu disetujui pelanggan dulu
        // sebelum dilanjutkan.
        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'pengecekan', 'menunggu_persetujuan', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");

        Schema::table('pengaduans', function (Blueprint $table) {
            // Rincian biaya perbaikan, diisi bersamaan dengan hasil_pemeriksaan
            // saat perlu_spkp = 'ya' dan ternyata ada biaya yang harus ditanggung pelanggan.
            $table->text('rincian_biaya')->nullable()->after('perlu_spkp');
            $table->decimal('total_biaya', 12, 2)->nullable()->after('rincian_biaya');

            // Status persetujuan pelanggan atas biaya tsb.
            // null      = belum ada biaya yang perlu disetujui
            // menunggu  = sudah dikirim ke pelanggan, menunggu respon
            // disetujui / ditolak = respon pelanggan
            $table->enum('status_persetujuan', ['menunggu', 'disetujui', 'ditolak'])->nullable()->after('total_biaya');
            $table->timestamp('tanggal_persetujuan')->nullable()->after('status_persetujuan');
            $table->text('catatan_persetujuan')->nullable()->after('tanggal_persetujuan'); // alasan pelanggan kalau menolak
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['rincian_biaya', 'total_biaya', 'status_persetujuan', 'tanggal_persetujuan', 'catatan_persetujuan']);
        });

        // Pindahkan dulu semua data 'menunggu_persetujuan' supaya gak ada baris
        // yang isinya value yang bakal dihapus dari enum.
        DB::statement("UPDATE pengaduans SET status = 'pengecekan' WHERE status = 'menunggu_persetujuan'");

        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'pengecekan', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");
    }
};
