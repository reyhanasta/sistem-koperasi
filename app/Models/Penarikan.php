<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    use HasFactory;

    public function bukuTabungan(){
        return $this->belongsTo(BukuTabungan::class,'id_rekening');
    }
}
