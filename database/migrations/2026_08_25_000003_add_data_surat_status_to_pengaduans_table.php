<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Jadwal rencana pengecekan lapangan (diisi admin saat assign petugas).
            // Ini beda dari tanggal_mulai_pengecekan (kapan suratnya diterbitkan/petugas ditugaskan).
            $table->dateTime('jadwal_pengecekan')->nullable()->after('petugas_id');
            $table->dateTime('tanggal_mulai_pengecekan')->nullable()->after('jadwal_pengecekan');

            // Snapshot nama petugas/pelaksana di titik waktu itu, supaya surat yang sudah
            // terbit gak ikut berubah kalau field petugas_id ditimpa ulang di tahap berikutnya
            // (petugas_id dipakai ulang untuk pelaksana proses perbaikan).
            $table->string('petugas_pengecekan_nama')->nullable()->after('tanggal_mulai_pengecekan');

            $table->dateTime('tanggal_mulai_proses')->nullable()->after('petugas_pengecekan_nama');
            $table->string('pelaksana_proses_nama')->nullable()->after('tanggal_mulai_proses');

            // Simpan catatan penyelesaian sebagai kolom sendiri (sebelumnya cuma ada
            // di pesan timeline), supaya gampang dipakai langsung di Surat Selesai.
            $table->text('catatan_selesai')->nullable()->after('tanggal_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn([
                'jadwal_pengecekan',
                'tanggal_mulai_pengecekan',
                'petugas_pengecekan_nama',
                'tanggal_mulai_proses',
                'pelaksana_proses_nama',
                'catatan_selesai',
            ]);
        });
    }
};
