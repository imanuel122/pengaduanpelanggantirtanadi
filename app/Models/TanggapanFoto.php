<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggapanFoto extends Model
{
    protected $fillable = ['tanggapan_pengaduan_id', 'path'];

    public function tanggapan()
    {
        return $this->belongsTo(TanggapanPengaduan::class, 'tanggapan_pengaduan_id');
    }

    // URL publik foto. Sengaja pakai path relatif ('/storage/...') bukan asset()/APP_URL,
    // supaya tetap benar walau domain lokal (.test) berubah-ubah dan APP_URL di .env lupa disesuaikan.
    public function url(): string
    {
        return '/storage/' . $this->path;
    }
}
