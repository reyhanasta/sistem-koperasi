<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use App\Models\BukuTabungan;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalPinjaman = Pinjaman::whereIn('status', ['diterima', 'berlangsung'])
        ->where('sisa_pinjaman', '>', 0)
        ->sum('sisa_pinjaman');
        $totalNasabah = Nasabah::count();
        $totalTabungan = BukuTabungan::sum('balance');
        return view('home', compact('totalPinjaman', 'totalTabungan', 'totalNasabah'));
    }
}
