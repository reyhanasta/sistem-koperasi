<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nasabahNotFoundWarning = 'Nasabah tidak ditemukan. Mohon tambahkan terlebih dahulu.';
        $successMessage = 'Data ditambahkan, buku tabungan nasabah diupdate.';

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Implementasikan logika angsuran di sini
            // Cari pinjaman berdasarkan ID
            $pinjaman = Pinjaman::findOrFail($request->id_pinjaman);

            // Lakukan validasi, misalnya, pastikan status pinjaman adalah "Pencairan" dan nasabah memiliki saldo cukup
            // Hilangkan tanda ribuan dan ganti tanda desimal jika perlu
            $angsuran_harian = (float) str_replace([',', '.'], ['', '.'], $request->angsuran);
            $sisaPinjaman = (float) str_replace([',', '.'], ['', '.'], $pinjaman->sisa_pinjaman);
            // // Lakukan pengurangan saldo nasabah
            // $nasabah = Nasabah::findOrFail($pinjaman->nasabah_id);
            // $nasabah->saldo -= $request->jumlah_angsuran;
            // $nasabah->save();
            // Update status pinjaman (misalnya, periksa jika pinjaman sudah lunas)
            if ($sisaPinjaman <= $angsuran_harian) {
                $pinjaman->status = 'Lunas';
            } else {
                $pinjaman->sisa_pinjaman = $sisaPinjaman - $angsuran_harian;
                $pinjaman->jumlah_angsuran += 1;
                $pinjaman->status = 'Proses Angsuran';
            }
            $pinjaman->save();

            // Simpan data angsuran
            $angsuran = new Angsuran();
            $angsuran->id_pinjaman = $pinjaman->id;
            $angsuran->nasabah_id = $pinjaman->nasabah_id;
            $angsuran->jumlah_angsuran = $angsuran_harian;
            $angsuran->tanggal_angsuran = now();
            $angsuran->save();

            // Commit transaksi database jika semua berhasil
            DB::commit();

            // Redirect atau kirim respons sesuai dengan kebutuhan Anda
            return redirect('/trx-pinjaman')->with('success', $successMessage);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data pinjaman: ' . $e->getMessage());
            // Tambahkan pesan kesalahan ke log atau tampilkan ke pengguna
            return back()->with('error', 'Terjadi kesalahan: ' . $nasabahNotFoundWarning);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
