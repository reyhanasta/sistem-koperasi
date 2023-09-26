<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function angsuran(){
        return $this->belongsTo(Angsuran::class,'id_angsuran');
    }
}
