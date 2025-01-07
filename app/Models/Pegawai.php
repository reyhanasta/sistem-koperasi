<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jabatan(){
        return $this->belongsTo(MasterJabatan::class,'master_jabatan_id');
    }

    /**
     * Scope a query to only include active pegawai.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['kontrak', 'tetap']);
    }

    /**
     * Get the full address of the Pegawai.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->phone}";
    }

    
    
}
