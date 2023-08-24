<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;
    
    public function bukuTabungan(){
        return $this->belongsTo(BukuTabungan::class);
    }
    public function nasabah(){
        return $this->belongsTo(Nasabah::class,'id_nasabah');
    }
}
