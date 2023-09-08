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
        $nasabahNotFoundWarning = 'Nasabah tidak ditemukan. Mohon tambahkan terlebih dahulu.';
        $successMessage = 'Data ditambahkan, buku tabungan nasabah diupdate.';

        $validatedData = $request->validate([
            // Atur aturan validasi sesuai kebutuhan
            'nasabah' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric',
            'jenis_pinjaman' => 'required',
            'tujuan_pinjaman' => 'required',
            'jangka_waktu' => 'required|integer',
            'bunga' => 'required|numeric',
            'catatan' => 'nullable', // Catatan bersifat opsional
        ]);

        if ($validatedData) {
            $data = new Pinjaman();
            $data->id_nasabah = $request->nasabah;
            $data->tanggal_pengajuan = $request->tanggal_pengajuan;
            $data->jumlah_pinjaman = $request->jumlah_pinjaman;
            $data->jenis_pinjaman = $request->jenis_pinjaman;
            $data->tujuan_pinjaman = $request->tujuan_pinjaman;
            $data->jangka_waktu = $request->jangka_waktu;
            $data->bunga = $request->bunga;
            $data->catatan = $request->catatan;

            $data->save();
            // return redirect('/trx-simpanan')->with('success', $successMessage);
            return redirect('/trx-pinjaman')->with('success', $successMessage);
        } else {
            return back()->with('warning', $nasabahNotFoundWarning);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pinjaman = Pinjaman::findOrFail($id);
        $previousUrl = url()->previous();
        return view('transaksi.pinjaman.show', compact('pinjaman','previousUrl'));
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
