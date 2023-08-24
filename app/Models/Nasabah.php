<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function simpanan(){
        return $this->hasMany(Simpanan::class);
    }
}
