<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Pinjaman;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PeminjamanNotification;

class PinjamanService{

    private $pinjaman;
    public function __construct(Pinjaman $pinjaman){
        $this->pinjaman = $pinjaman;
    }
    public function store($request,$angsuran,$totalBayar,$code){
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->firstOrFail();
        $pinjaman = $this->pinjaman->buatPinjaman($request,$angsuran,$totalBayar,$code,$pegawai);
        // Ambil semua user dengan role admin menggunakan Spatie
        $admins = Role::findByName('admin')->users;   
        // Kirim notifikasi ke setiap admin
        foreach ($admins as $admin) {
            $admin->notify(new PeminjamanNotification($pinjaman));
        }
        
    }
}

