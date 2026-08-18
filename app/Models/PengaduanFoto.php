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

    // URL publik foto (disk 'public' -> butuh php artisan storage:link)
    public function url(): string
    {
        return asset('storage/' . $this->path);
    }
}
