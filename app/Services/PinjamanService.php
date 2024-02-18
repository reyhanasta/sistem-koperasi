<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;

class PinjamanService{

    private $pinjaman;
    public function __construct(Pinjaman $pinjaman){
        $this->pinjaman = $pinjaman;
    }
    public function store($request,$angsuran,$totalBayar,$code){
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->firstOrFail();
        $this->pinjaman->buatPinjaman($request,$angsuran,$totalBayar,$code,$pegawai);
        
    }
}

