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

    // URL publik foto (disk 'public' -> butuh php artisan storage:link)
    public function url(): string
    {
        return asset('storage/' . $this->path);
    }
}
