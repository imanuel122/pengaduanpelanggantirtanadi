<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapan_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tanggapan_pengaduan_id')->constrained('tanggapan_pengaduans')->cascadeOnDelete();
            $table->string('path'); // path file di storage (disk 'public')
            $table->timestamps();
        });

        // Kolom foto_dokumentasi lama (cuma 1 foto) sudah digantikan tabel ini,
        // jadi bisa dihapus.
        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            $table->dropColumn('foto_dokumentasi');
        });
    }

    public function down(): void
    {
        Schema::table('tanggapan_pengaduans', function (Blueprint $table) {
            $table->string('foto_dokumentasi')->nullable();
        });

        Schema::dropIfExists('tanggapan_fotos');
    }
};
