<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pinjaman extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function nasabah(){
        return $this->belongsTo(Nasabah::class,'id_nasabah');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai');
    }

    public function angsuran(){
        return $this->hasMany(Angsuran::class); 
    }
}