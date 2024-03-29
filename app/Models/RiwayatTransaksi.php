<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    use HasFactory;

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id','id');
    }
    public function bukuTabungan()
    {
        return $this->belongsTo(BukuTabungan::class, 'tabungan_id','id');
    }
}
