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
        $totalNasabahBulanan = Nasabah::whereMonth('created_at', now()->month)->count();
        $totalTabungan = BukuTabungan::sum('balance');
         // Data peminjaman bulanan
         $monthlyLoans = Pinjaman::selectRaw('MONTH(created_at) as month, SUM(jumlah_pinjaman) as total')
         ->groupBy('month')
         ->get()
         ->pluck('total', 'month')
         ->toArray();
        return view('home', compact('totalPinjaman','totalTabungan', 'totalNasabah', 'totalNasabahBulanan', 'monthlyLoans'));
    }
}
