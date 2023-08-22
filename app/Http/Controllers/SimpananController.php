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
         //
         $data = new Simpanan;
         $Nasabah = Nasabah::all();
         $back = url()->previous();
         $confirm = "return confirm('Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi')";
         return view('transaksi.simpanan.add', compact('data', 'Nasabah', 'back', 'confirm'));
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         //
         $data = new Simpanan();
         //$id_rekening = BukuTabungan::findBy('id_nasabah',$request->Nasabah);
         $rekeningNasabah = BukuTabungan::where('id_nasabah', $request->Nasabah)->first();
         $validateData = $request->validate([
             'Nasabah' => 'required',
             'amount' => ['required','min:5000','numeric'],
         ]);
         if ($validateData) {
 
             $data->id_nasabah = $rekeningNasabah->id;
             $data->type = $request->type;
             $data->amount = $request->amount;
             $data->desc = $request->desc;
             $rekeningNasabah->balance += $request->amount;
             $rekeningNasabah->save();
             $data->save();
             return redirect('/tr-Simpanans')->with('success', 'Data berhasil di tambahkan dan buku tabungan nasabah berhasil di Update!');
         }
         return back()->with('warning', 'Data Nasabah masih kosong, harap tambahkan terlebih dahulu');
 
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
