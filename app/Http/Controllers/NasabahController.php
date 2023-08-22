<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\BukuTabungan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Nasabah::all()->sortByDesc('created_at');
        return view('nasabah.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new Nasabah;
        $back = url()->previous();
        return view('nasabah.add', compact('data', 'back'));
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

        //Nasabah DATA
        $nasabah = new Nasabah;
        $nasabah->name = $request->name;
        $nasabah->gender = $request->gender;
        $nasabah->phone = $request->phone;
        $nasabah->address = $request->address;
        $nasabah->date_of_birth = $request->date;
        //  if($request->file('profile_pict')){
        //      $file=$request->file('profile_pict');
        //      $nama_file = time().str_replace(" ","",$file->getClientOriginalName());
        //      $file->move('picture',$nama_file);
        //      $nasabah->profile_pict = $nama_file;
        //  }
        $nasabah->save();
        if ($nasabah->save()) {
            $buku_nasabah = new BukuTabungan;
            $buku_nasabah->id_Nasabah = $nasabah->id;
            $buku_nasabah->balance = 5000;
            $buku_nasabah->status = "aktif";
            $buku_nasabah->save();
        }
        return redirect('/Nasabah')->with('success', 'Data Nasabah beserta buku tabungannya berhasil di Tambahkan !');
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
        $data = Nasabah::findorFail($id);
        $dataTabungan = BukuTabungan::where('id_Nasabah', $id)->first();
        $back = url()->previous();
        return view('nasabah.show', compact('data', 'dataTabungan', 'back'));
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
        $data = Nasabah::find($id);
        $back = url()->previous();
        return view('nasabah.edit', compact('data', 'back'));

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
        $data = Nasabah::find($id);
        $data->name = $request->name;
        $data->gender = $request->gender;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->date_of_birth = $request->date;
        $data->save();
        return redirect('/Nasabah')->with('success', 'Data Berhasil di Simpan');

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
        $data = Nasabah::find($id);
        $data->delete();
        //mass delete
        //Controller::destroy($id);
        return redirect('Nasabah')->with('success', 'Data Berhasil di Hapus');
    }
    
}
