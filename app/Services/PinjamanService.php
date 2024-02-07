<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;

class PinjamanService{
    public function totalBayar($request){
        $total_pembayaran = $request->jumlah_pinjaman * (1 - ($request->bunga / 100));
        return $total_pembayaran;
    }
    public function angsuran($request,$total){
        $angsuran = $total / $request->jangka_waktu;
        return $angsuran;
    }

    public function store($request,$angsuran,$totalBayar,$code){
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->firstOrFail();
        Pinjaman::create([
            'nasabah_id' => $request->nasabah,
            'kode_pinjaman' => $code,
            'id_pegawai' => $pegawai->id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'jenis_pinjaman' => $request->jenis_pinjaman,
            'tujuan_pinjaman' => $request->tujuan_pinjaman,
            'jangka_waktu' => $request->jangka_waktu,
            'catatan' => $request->catatan,
            'angsuran' => $angsuran,
            'sisa_pinjaman' => $totalBayar,
            'total_pembayaran' => $totalBayar,
        ]);
    }
}
?>
