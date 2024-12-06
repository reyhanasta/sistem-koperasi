<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    use HasFactory;
    protected $casts = [
        'nominal' => 'float',
        'saldo_akhir' => 'float',
    ];

    public static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if ($model->nominal > 1000000000) { // Sesuaikan batas maksimum
            throw new \Exception('Nominal terlalu besar.');
        }
    });
}

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id','id');
    }
    public function bukuTabungan()
    {
        return $this->belongsTo(BukuTabungan::class, 'tabungan_id','id');
    }
}
