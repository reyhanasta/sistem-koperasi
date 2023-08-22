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
        $data = Penarikan::with('Nasabah_acc')->get()->sortByDesc('created_at');
        $back = url()->previous();
        return view('transaksi.penarikan.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new Penarikan;
        $Nasabah = Nasabah::all();
        $back = url()->previous();
        $confirm = "return confirm('Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi')";
        return view('transaksi.penarikan.add', compact('Nasabah', 'data', 'back', 'confirm'));
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
        $data = new Penarikan;
        $rekeningNasabah = BukuTabungan::where('id_Nasabah', $request->Nasabah)->first();
        $validateData = $request->validate([
            'Nasabah' => 'required',
            'amount' => [
                'required',
                'min:20000',
                'numeric',
                function ($attribute, $value, $fail) use ($rekeningNasabah) {
                    $balance = $rekeningNasabah->balance;
                    if ($value > $balance) {
                        return $fail("The $attribute must not be greater than the account balance.");
                    }
                },
            ],
        ]);
        $data->Nasabah_acc_id = $rekeningNasabah->id;
        $data->amount = $request->amount;
        $data->desc = $request->desc;
        $rekeningNasabah->balance -= $request->amount;
        $rekeningNasabah->save();
        $data->save();

        return redirect('tr-withdraw/')->with('success', 'Data Berhasil Di tambahkan!');
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
