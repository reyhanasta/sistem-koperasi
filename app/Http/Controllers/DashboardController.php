<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use App\Models\BukuTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi yang belum dibaca
        $notifications = $user->unreadNotifications;
        // Menyimpan notifikasi dalam session
        session()->put('notifications', $notifications);


        $totalPinjaman = Pinjaman::whereIn('status', ['diterima', 'berlangsung'])
        ->where('sisa_pinjaman', '>', 0)
        ->sum('sisa_pinjaman');
        $totalNasabah = Nasabah::count();
        $totalNasabahBulanan = Nasabah::whereMonth('created_at', now()->month)->count();
        $totalTabungan = BukuTabungan::sum('balance');
         // Data peminjaman bulanan
         $monthlyLoans = Pinjaman::selectRaw('MONTH(created_at) as month, SUM(jumlah_pinjaman) as total')
         ->whereIn('status', ['diterima', 'berlangsung'])
         ->groupBy('month')
         ->get()
         ->pluck('total', 'month')
         ->toArray();
         
         $monthlyAccLoans = Pinjaman::whereIn('status', ['diterima', 'berlangsung'])
         ->whereMonth('tanggal_persetujuan', now()->month)->count();

          // Hitung peningkatan dari bulan sebelumnya
        $previousMonth = Carbon::now()->subMonth()->month;
        $currentMonth = Carbon::now()->month;
        $previousMonthLoans = $monthlyLoans[$previousMonth] ?? 0;
        $currentMonthLoans = $monthlyLoans[$currentMonth] ?? 0;
        $increasePercentage = $previousMonthLoans > 0 ? (($currentMonthLoans - $previousMonthLoans) / $previousMonthLoans) * 100 : 0;
       
         // Hitung total pinjaman Year to Date
         $startOfYear = Carbon::now()->startOfYear();
         $totalPinjamanYTD = Pinjaman::whereIn('status', ['diterima', 'berlangsung'])
             ->where('created_at', '>=', $startOfYear)
             ->sum('jumlah_pinjaman');
 
       
        // Data Nasabah bulanan
        $monthlyNasabah = Nasabah::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
           // Hitung peningkatan dari bulan sebelumnya untuk nasabah
        $previousMonthNasabah = $monthlyNasabah[$previousMonth] ?? 0;
        $currentMonthNasabah = $monthlyNasabah[$currentMonth] ?? 0;
        $increasePercentageNasabah = $previousMonthNasabah > 0 ? (($currentMonthNasabah - $previousMonthNasabah) / $previousMonthNasabah) * 100 : 0;

         // Hitung rata-rata nasabah per bulan
         $totalMonths = count($monthlyNasabah);
         $totalNasabahBulanan = array_sum($monthlyNasabah);
         $averageNasabahPerMonth = $totalMonths > 0 ? $totalNasabahBulanan / $totalMonths : 0;

        return view('home', compact(
            'totalPinjaman',
            'totalTabungan', 
            'totalNasabah', 
            'totalNasabahBulanan', 
            'monthlyLoans',
            'monthlyNasabah',
            'increasePercentage',
            'increasePercentageNasabah',
            'averageNasabahPerMonth',
            'totalPinjamanYTD','monthlyAccLoans','notifications'));


    }

    public function markAsRead(Request $request)
{
    $user = Auth::user();

    // Tandai semua notifikasi sebagai dibaca
    $user->unreadNotifications->markAsRead();

    return redirect()->route('pinjaman.index');
}
}
