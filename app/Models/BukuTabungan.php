<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTabungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'no_rek',
        'nasabah_id',
        'balance',
        'status',
        'notes',
        'closed_date',
    ];

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class);
    }
    public function penarikan()
    {
        return $this->hasMany(Penarikan::class);
    }

    public function riwayatTransaksi()
    {
        return $this->hasMany(BukuTabungan::class);
    }
}
