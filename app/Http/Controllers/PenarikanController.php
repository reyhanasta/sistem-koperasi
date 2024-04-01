<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\BukuTabungan;

use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use Illuminate\Routing\Controller;
use App\Http\Requests\PenarikanRequest;

class PenarikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Penarikan::with('bukuTabungan')->get()->sortByDesc('created_at');

        return view('transaksi.penarikan.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Penarikan();
        $nasabahList = Nasabah::all();

        $previousUrl = url()->previous();
        $confirmationMessage = "Pastikan Data sudah di isi dengan benar,
        karena data transaksi tidak dapat di ubah lagi";

        return view('transaksi.penarikan.add', compact('nasabahList', 'data', 'previousUrl', 'confirmationMessage'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    public function store(PenarikanRequest $request)
    {
        // Retrieve the RekeningNasabah
        $rekeningNasabah = BukuTabungan::where('nasabah_id', $request->nasabah)->first();
      
        // Validate the request data
        $validatedData = $request->validated();

        // Check if validation passes
        if ($validatedData) {
            // Create a new Penarikan instance
            $data = new Penarikan();
            $data->id_rekening = $rekeningNasabah->id;
            $data->nasabah_id = $request->nasabah;
            $data->amount = $request->amount;
            $data->desc = $request->desc;

            // Update the balance of RekeningNasabah
            $rekeningNasabah->balance -= $request->amount;
            $rekeningNasabah->save();

            //Update Riwayat Transaksi
            $history = new RiwayatTransaksi();
            $history->tabungan_id = $rekeningNasabah->id;
            $history->nominal = $request->amount;
            $history->saldo_akhir = $rekeningNasabah->balance;
            $history->type = "kredit";
            $history->id_pegawai =  auth()->user()->id;
            $history->save();
            
            // Save changes to RekeningNasabah and Penarikan
            $data->save();

            return redirect('trx-penarikan')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            // Redirect back with the old input and validation errors
            return redirect()->back()->withErrors($validatedData)->withInput();
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
        $x = BukuTabungan::where('nasabah_id', $id)->first();

        return response()->json($x);
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
