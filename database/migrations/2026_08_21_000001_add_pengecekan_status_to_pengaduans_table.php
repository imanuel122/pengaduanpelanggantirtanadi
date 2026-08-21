<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah 'pengecekan' ke enum status. Pakai raw SQL karena mengubah
        // definisi ENUM butuh ini di MySQL (tidak bisa lewat Schema::table biasa).
        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'pengecekan', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");
    }

    public function down(): void
    {
        // Ubah dulu semua data 'pengecekan' jadi 'baru' supaya gak ada baris
        // yang isinya value yang bakal dihapus dari enum.
        DB::statement("UPDATE pengaduans SET status = 'baru' WHERE status = 'pengecekan'");

        DB::statement("
            ALTER TABLE pengaduans
            MODIFY status ENUM('baru', 'diverifikasi', 'diproses', 'selesai', 'ditolak')
            NOT NULL DEFAULT 'baru'
        ");
    }
};
