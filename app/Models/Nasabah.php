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

    
    // protected $fillable = [
    //     'name',
    //     'ktp',
    //     'gender',
    //     'phone',
    //     'ktp_image_path',
    //     'address',
    //     'date_of_birth',
    //     'closure_date',
    // ];

    protected static function booted()
    {
        static::created(function ($nasabah) {
            $nasabah->bukuTabungan()->create([
                'no_rek' => '2024' . str_pad($nasabah->id, 6, '0', STR_PAD_LEFT),
                'balance' => 5000,
                'status' => 'aktif',
            ]);
        });
    }
    

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

    public function bukuTabungan()
    {
        return $this->hasOne(BukuTabungan::class, 'nasabah_id');
    }

    
}
