<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_pengaduan_id');
    }
}
