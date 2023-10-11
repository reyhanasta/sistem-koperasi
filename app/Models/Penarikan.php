<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penarikan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function bukuTabungan()
    {
        return $this->belongsTo(BukuTabungan::class, 'id_rekening');
    }
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }
}
