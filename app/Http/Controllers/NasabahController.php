<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Penarikan;
use Illuminate\Support\Facades\DB;
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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
        ]);

        // Wrap the database operations in a transaction
        DB::transaction(function () use ($validatedData) {
            // Create and save a new Nasabah
            $nasabah = Nasabah::create($validatedData);
            $date = $validatedData['date_of_birth'];
            $formattedDate = date('md', strtotime($date));
            $padString = date('ymd') . $formattedDate;
            $point = $nasabah->id;
            $nomor_rekening = str_pad($point, 12, $padString, STR_PAD_LEFT);
            
            // Create and save a new BukuTabungan
            if ($nasabah) {
                BukuTabungan::create([
                    'id_nasabah' => $nasabah->id,
                    'no_rek' => $nomor_rekening,
                    'balance' => 5000,
                    'status' => 'aktif',
                ]);
            }
        });

        return redirect('/nasabah')->with('success', 'Data Nasabah beserta buku tabungannya berhasil di Tambahkan !');
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
        $dataTabungan = BukuTabungan::where('id_nasabah', $id)->first();
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
        return redirect('/nasabah')->with('success', 'Data Berhasil di Simpan');
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
        return redirect('nasabah')->with('success', 'Data Berhasil di Hapus');
    }
}
