<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;
    
    public function customerAccount(){
        return $this->belongsTo(CustomerAccount::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
}
