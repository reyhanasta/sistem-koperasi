<?php

namespace App\Http\Controllers;


use App\Models\BukuTabungan;
use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;


class RiwayatTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $nasabahService;
    protected $previousUrl;

    public function __construct()
    {
        
    }

    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        

        $previousUrl = url()->previous();
        $bukuTabungan = BukuTabungan::where('nasabah_id',$id)->first();
        // Ambil riwayat transaksi peminjaman nasabah berdasarkan ID nasabah
        $riwayatTransaksi = RiwayatTransaksi::with('pegawai')->where('tabungan_id',
        $bukuTabungan->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('transaksi.riwayat.riwayat', compact('riwayatTransaksi', 'previousUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatTransaksi $riwayatTransaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatTransaksi $riwayatTransaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatTransaksi $riwayatTransaksi)
    {
        //
    }
}
