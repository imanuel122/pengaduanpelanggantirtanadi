<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Kapan pengaduan resmi ditolak/dibatalkan -- baik ditolak admin (saat pengecekan)
            // maupun dibatalkan pelanggan sendiri (menolak biaya perbaikan). Dipakai sebagai
            // penanda ketersediaan + tanggal Surat Pemberitahuan Penolakan.
            $table->dateTime('tanggal_ditolak')->nullable()->after('catatan_verifikasi_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn('tanggal_ditolak');
        });
    }
};
