<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTabungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function simpanan(){
        return $this->hasMany(Simpanan::class);
    }
    public function penarikan(){
        return $this->hasMany(Penarikan::class);
    }
}
