<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah status 'menunggu_verifikasi_pembayaran' ke enum, di antara
        // 'menunggu_persetujuan' dan 'diverifikasi'. Dipakai saat pelanggan sudah
        // setuju & upload bukti bayar, tapi admin belum mengecek buktinya.
        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'pengecekan', 'menunggu_persetujuan', 'menunggu_verifikasi_pembayaran', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");

        Schema::table('pengaduans', function (Blueprint $table) {
            // Dokumen rincian biaya (Word/Excel/PDF) yang diupload admin, menggantikan
            // rincian_biaya berupa teks bebas -> sekarang pelanggan bisa lihat/unduh filenya langsung.
            $table->string('rincian_biaya_file')->nullable()->after('rincian_biaya');
            $table->string('rincian_biaya_file_nama_asli')->nullable()->after('rincian_biaya_file');

            // Bukti pembayaran yang diupload pelanggan saat menyetujui biaya.
            $table->string('bukti_pembayaran')->nullable()->after('catatan_persetujuan');
            $table->string('bukti_pembayaran_nama_asli')->nullable()->after('bukti_pembayaran');

            // Catatan admin kalau bukti pembayaran ditolak (diminta upload ulang).
            $table->text('catatan_verifikasi_pembayaran')->nullable()->after('bukti_pembayaran_nama_asli');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn([
                'rincian_biaya_file',
                'rincian_biaya_file_nama_asli',
                'bukti_pembayaran',
                'bukti_pembayaran_nama_asli',
                'catatan_verifikasi_pembayaran',
            ]);
        });

        DB::statement("UPDATE pengaduans SET status = 'menunggu_persetujuan' WHERE status = 'menunggu_verifikasi_pembayaran'");

        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'pengecekan', 'menunggu_persetujuan', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");
    }
};
