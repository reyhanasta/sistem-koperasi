<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\BukuTabungan;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

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
        $data = new Penarikan;
        $nasabahList = Nasabah::all();
        $previousUrl = url()->previous();
        $confirmationMessage = "Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi";

        return view('transaksi.penarikan.add', compact('nasabahList', 'data', 'previousUrl', 'confirmationMessage'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rekeningNasabah = BukuTabungan::where('id_nasabah', $request->nasabah)->first();

        $validateData = $request->validate([
            'nasabah' => 'required', // Change 'Nasabah' to 'nasabah'
            'amount' => [
                'required',
                'min:20000',
                'numeric',
                function ($attribute, $value, $fail) use ($rekeningNasabah) {
                    $balance = $rekeningNasabah->balance;
                    
                    if ($value > $balance) {
                        $fail("The $attribute must not be greater than the account balance.");
                    }
                },
            ],
        ]);

        if ($validateData) {
            $data = new Penarikan; // Move the creation of $data inside the validation check
            $data->id_rekening = $rekeningNasabah->id;
            $data->amount = $request->amount;
            $data->desc = $request->desc;
            $rekeningNasabah->balance -= $request->amount;
            
            $rekeningNasabah->save();
            $data->save();
            return redirect('trx-penarikan')->with('success', 'Data Berhasil Ditambahkan!');
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
