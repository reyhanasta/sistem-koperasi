<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArsipSimpananController extends Controller
{
    //
    public function create(Request $request, Nasabah $nasabah)
    {
        // Validasi inputan jika diperlukan
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Buat entri dalam tabel Simpanan
        Simpanan::create([
            'nasabah_id' => $nasabah->id,
            'jumlah' => $request->input('jumlah'),
            'tanggal' => $request->input('tanggal'),
            'keterangan' => $request->input('keterangan'),
        ]);

        // Kemudian Anda bisa mengarahkan pengguna kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Simpanan berhasil diarsipkan.');
    }
}
