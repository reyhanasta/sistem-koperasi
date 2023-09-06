<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTabungan;
use App\Models\Simpanan;
use App\Models\Nasabah;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        // $data = Simpanan::all()->sortByDesc('created_at');
        // Mendapatkan semua data anggota beserta data pinjaman yang dimilikinya
        $data = Simpanan::with('Nasabah')->get()->sortByDesc('created_at');
        $back = url()->previous();

        return view('transaksi.simpanan.list', compact('data', 'back'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create a new Simpanan instance
        $data = new Simpanan;
        // Fetch all Nasabah data
        $nasabahList = Nasabah::all();
        // Get the previous URL for navigation
        $previousUrl = url()->previous();
        // Confirmation message for data input
        $confirmMessage = "Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi";

        // Pass data to the view using compact()
        return view('transaksi.simpanan.add', compact('data', 'nasabahList', 'previousUrl', 'confirmMessage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pesan-pesan yang akan digunakan
        $nasabahNotFoundWarning = 'Nasabah tidak ditemukan. Mohon tambahkan terlebih dahulu.';
        $confirmMessage = 'Data ditambahkan, buku tabungan nasabah diupdate.';

        // Cari rekening nasabah berdasarkan ID nasabah
        $rekeningNasabah = BukuTabungan::where('id_nasabah', $request->nasabah)->first();

        // Jika rekening nasabah ditemukan
        if ($rekeningNasabah) {
            // Buat objek Simpanan
            $data = new Simpanan();
            $data->id_rekening = $rekeningNasabah->id;
            $data->id_nasabah = $request->nasabah;
            $data->type = $request->type;
            $data->amount = $request->amount;
            $data->desc = $request->desc;

            // Update saldo buku tabungan nasabah
            $rekeningNasabah->balance += $request->amount;
            $rekeningNasabah->save();

            // Simpan data transaksi Simpanan
            $data->save();

            // Redirect ke halaman yang sesuai dan sertakan pesan sukses
            return redirect('/trx-simpanan')->with('success', $confirmMessage);
        } else {
            // Jika nasabah tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan peringatan
            return back()->with('warning', $nasabahNotFoundWarning);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
