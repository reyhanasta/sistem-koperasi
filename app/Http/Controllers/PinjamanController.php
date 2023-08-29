<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Penarikan;
use Illuminate\Support\Facades\DB;
use App\Models\BukuTabungan;
use App\Http\Controllers\Controller;


class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Pinjaman::all(); // Ambil semua data pinjaman dari database
        $urlCreate = url('trx-pinjaman/create/');
        return view('transaksi.pinjaman.list', compact('data', 'urlCreate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = new Pinjaman;
        $nasabahList = Nasabah::all();
        $previousUrl = url()->previous();
        $confirmMessage = "Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi";

        return view('transaksi.pinjaman.add', compact('data', 'nasabahList', 'previousUrl', 'confirmMessage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lakukan validasi data yang masuk
        dd($request);
        $validatedData = $request->validate([
            // Atur aturan validasi sesuai kebutuhan
            'nasabah' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric',
            'jenis_pinjaman' => 'required',
            'tujuan_pinjaman' => 'required',
            'jangka_waktu' => 'required|integer',
            'bunga' => 'required|numeric',
            'metode_pembayaran' => 'required',
            'catatan' => 'nullable', // Catatan bersifat opsional
        ]);

        // Simpan data pinjaman ke database
        Pinjaman::create($validatedData);

        return redirect()->route('transaksi.pinjaman.index')->with('success', 'Pinjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pinjaman = Pinjaman::findOrFail($id);
        return view('pinjaman.show', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pinjaman = Pinjaman::findOrFail($id);
        return view('pinjaman.edit', compact('pinjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Lakukan validasi data yang masuk
        $validatedData = $request->validate([
            // Atur aturan validasi sesuai kebutuhan
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update($validatedData);

        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil dihapus.');
    }
}
