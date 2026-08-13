<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggapanPengaduan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'pesan',
        'status_baru',
        'foto_dokumentasi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
