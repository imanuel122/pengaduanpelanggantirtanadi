<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            // Nullable: null berarti belum pernah diedit. Diisi tiap kali petugas/admin
            // mengedit pesan/foto catatan progres, supaya riwayatnya tetap transparan
            // (bukan diam-diam ditimpa tanpa jejak).
            $table->timestamp('edited_at')->nullable()->after('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            $table->dropColumn('edited_at');
        });
    }
};
