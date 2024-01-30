<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }
    public function angsuran()
    {
        return $this->hasMany(Angsuran::class);
    }
    public function penarikan()
    {
        return $this->hasMany(Penarikan::class);
    }
    public function riwayat()
    {
        return $this->hasMany(RiwayatTransaksi::class);
    }
}
