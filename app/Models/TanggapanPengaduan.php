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

    public function fotos()
    {
        return $this->hasMany(TanggapanFoto::class);
    }

    // Warna titik timeline di halaman Lacak Pengaduan, tergantung status_baru saat itu
    public function dotColorClass(): string
    {
        return match ($this->status_baru) {
            'baru' => 'bg-brand-blue',
            'pengecekan' => 'bg-violet-500',
            'diverifikasi' => 'bg-amber-400',
            'diproses' => 'bg-brand-teal',
            'selesai' => 'bg-brand-green',
            'ditolak' => 'bg-red-500',
            default => 'bg-slate-300', // entri tanpa perubahan status, cuma komentar/tanggapan
        };
    }
}
