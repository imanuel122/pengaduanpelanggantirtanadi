<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanFoto extends Model
{
    protected $fillable = ['pengaduan_id', 'path'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // URL publik foto. Sengaja pakai path relatif ('/storage/...') bukan asset()/APP_URL,
    // supaya tetap benar walau domain lokal (.test) berubah-ubah dan APP_URL di .env lupa disesuaikan.
    public function url(): string
    {
        return '/storage/' . $this->path;
    }
}
