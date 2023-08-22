<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterJabatan;

class MasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = MasterJabatan::all();
        $back = url()->previous();
        return view('master.jabatan.list',compact('data','back'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new MasterJabatan;
        $back = url()->previous();
        return view('master.jabatan.add',compact('data','back'));
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
        $data = new MasterJabatan;
        $data->name = $request->name;
        $data->save();

        return redirect('/master-jabatan')->with('success','Data berhasil ditambahkan !');
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
        $data = MasterJabatan::find($id);
        $back = url()->previous();
        return view('master.jabatan.edit',compact('data','back'));
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
        $data = MasterJabatan::findorFail($id);
        $data->name = $request->name;
        $data->save();
        return redirect('master-jabatan')->with('success','Data Berhasil di Ubah !');
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
        $data = MasterJabatan::find($id);
        $data->delete();
        
        return redirect('/master-jabatan')->with('success','Data Berhasil di Hapus !');
    }
}
