<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    use HasFactory;

    public function customer_acc(){
        return $this->belongsTo(CustomerAccount::class,'customer_acc_id');
    }
}
