<?php

namespace App\Models;

use App\Models\Pinjaman;
use App\Models\Simpanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    
    public function simpanan(){
        return $this->hasMany(Simpanan::class);
    }
    
    public function pinjaman(){
        return $this->hasMany(Pinjaman::class);
    }
}
