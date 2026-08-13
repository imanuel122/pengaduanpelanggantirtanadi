<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapan_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->cascadeOnDelete();

            // nullable: entri otomatis sistem (misal "Pengaduan berhasil dikirim") tidak punya user
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('pesan'); // teks yang tampil di timeline, misal "Pengaduan sedang diverifikasi pegawai"
            $table->string('status_baru')->nullable(); // status pengaduan setelah entri ini (kalau berubah)
            $table->string('foto_dokumentasi')->nullable(); // foto hasil perbaikan dari petugas
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduans');
    }
};
