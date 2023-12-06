<?php

namespace App\Http\Controllers;

use App\Models\BukuTabungan;

class BukuTabunganController extends Controller
{
    public function getSaldo($id){
        $saldo = BukuTabungan::where('nasabah_id',$id)->get();
        return response()->json($saldo);
    }
}
