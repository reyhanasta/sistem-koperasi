<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTabungan;
use App\Models\Simpanan;
use App\Models\Nasabah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Impor Log class

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
        $data = Simpanan::with('Nasabah')->where('diarsipkan', 0)->get()->sortByDesc('created_at');
        $back = url()->previous();

        return view('transaksi.simpanan.list', compact('data', 'back'));
    }
    public function riwayatSimpanan($nasabah_id)
    {
        // Cari nasabah berdasarkan ID
        $nasabah = Nasabah::find($nasabah_id);
        $previousUrl = url()->previous();

        if (!$nasabah) {
            return back()->with('warning', 'Nasabah tidak ditemukan.');
        }
        // Ambil riwayat transaksi simpanan nasabah berdasarkan ID nasabah
        $riwayatSimpanan = Simpanan::where('nasabah_id', $nasabah_id)->orderBy('created_at', 'desc')->get();
        return view('transaksi.simpanan.riwayat', compact('nasabah', 'riwayatSimpanan', 'previousUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Generate kode transaksi
        $kodeInput = $this->generateTransactionCode();
        // Create a new Simpanan instance
        $data = new Simpanan;
        // Fetch all Nasabah data
        $nasabahList = Nasabah::all();
        // Get the previous URL for navigation
        $previousUrl = url()->previous();
        // Confirmation message for data input
        $confirmMessage = "Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi";
        // Pass data to the view using compact()
        return view('transaksi.simpanan.add', compact('data', 'nasabahList', 'previousUrl', 'confirmMessage', 'kodeInput'));
    }

    private function generateTransactionCode()
    {
        $now = now();
        $year = $now->format('y');
        $month = $now->format('m');
        $baseCode = "S{$year}{$month}";

        // Mengecek apakah kode sudah terdaftar di database
        $existingCount = Simpanan::where('kode_simpanan', 'like', "{$baseCode}%")->count();

        // Menghasilkan kode dengan nomor urut yang sesuai
        $transactionCount = $existingCount + 1;

        return $baseCode . sprintf("%03d", $transactionCount);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pesan-pesan yang akan digunakan
        $nasabahNotFoundWarning = 'Nasabah tidak ditemukan. Mohon tambahkan terlebih dahulu.';
        $confirmMessage = 'Data ditambahkan, buku tabungan nasabah diupdate.';

        try {
            // Memulai transaksi database
            DB::beginTransaction();

            // Cari rekening nasabah berdasarkan ID nasabah
            $rekeningNasabah = BukuTabungan::where('nasabah_id', $request->nasabah)->first();
            if (!$rekeningNasabah) {
                // Jika nasabah tidak ditemukan, batalkan transaksi dan kembalikan ke halaman sebelumnya dengan pesan peringatan
                DB::rollBack();
                return back()->with('warning', $nasabahNotFoundWarning);
            }

            // Buat objek Simpanan
            $data = new Simpanan();
            $data->id_rekening = $rekeningNasabah->id;
            $data->nasabah_id = $request->nasabah;
            $data->kode_simpanan = $request->kode;
            $data->type = $request->type;
            $data->amount = $request->amount;
            $data->desc = $request->desc;

            // Update saldo buku tabungan nasabah
            $rekeningNasabah->balance += $request->amount;
            $rekeningNasabah->save();

            // Simpan data transaksi Simpanan
            $data->save();

            // Commit transaksi jika semuanya berhasil
            DB::commit();

            // Redirect ke halaman yang sesuai dan sertakan pesan sukses
            return redirect('/trx-simpanan')->with('success', $confirmMessage);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, batalkan transaksi, tampilkan pesan kesalahan, dan log error
            DB::rollBack();
            Log::error('Terjadi kesalahan dalam transaksi simpanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
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
