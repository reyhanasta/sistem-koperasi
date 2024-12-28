<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Simpanan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'id_rekening',
        'nasabah_id',
        'pegawai_id',
        'kode_simpanan',
        'type',
        'nominal',
        'saldo_akhir',
        'desc',
    ];
   
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function bukuTabungan()
    {
        return $this->belongsTo(BukuTabungan::class, 'id_rekening');
    }

    /**
     * Handle withdrawal from the simpanan.
     *
     * @param float $amount
     * @return bool
     */
    public function withdraw(float $amount): bool
    {
        if ($amount > $this->saldo_akhir) {
            return false; // Insufficient funds
        }

        $this->saldo_akhir -= $amount;
        $this->save();

        return true;
    }
}
