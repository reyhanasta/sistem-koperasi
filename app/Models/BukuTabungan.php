<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTabungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function savings(){
        return $this->hasMany(Saving::class);
    }
    public function withdraw(){
        return $this->hasMany(Withdrawal::class);
    }
}
