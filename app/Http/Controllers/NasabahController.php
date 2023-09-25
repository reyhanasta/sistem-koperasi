<?php

namespace App\Http\Controllers;

use Carbon\Carbon;


use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Simpanan;

use App\Models\BukuTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\NasabahRequest;
use Illuminate\Support\Facades\Storage;




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
        $data = Nasabah::latest()->get();
       
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

    public function store(NasabahRequest $request)
    {
        try {
            // Wrap the database operations in a transaction
            DB::transaction(function () use ($request) {
                // Create and save a new Nasabah
                $nasabah = Nasabah::create($request->validated());
                $date = $request->input('date_of_birth');
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

                // Simpan gambar KTP (jika diunggah)
                if ($request->hasFile('ktp_image_path')) {
                    $imagePath = $request->file('ktp_image_path')->store('ktp_images/' . uniqid(), 'public');
                    $imageName = basename($imagePath);
                    $nasabah->update(['ktp_image_path' => $imageName]);
                }
            });

            return redirect('/nasabah')->with('success', 'Data Nasabah beserta buku tabungannya berhasil di Tambahkan !');
        } catch (\Exception $e) {
            Log::error('Error while adding Nasabah data: ' . $e->getMessage());
            return redirect('/nasabah')->with('error', 'Terjadi kesalahan saat menambahkan data Nasabah. Silakan coba lagi.');
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
        $data = Nasabah::findorFail($id);
        $dataTabungan = BukuTabungan::where('id_nasabah', $id)->first();
        //Ambil umur
        $birthdate = Carbon::parse($data->date_of_birth);
        $currentDate = Carbon::now();
        $age = $birthdate->diffInYears($currentDate);
        // Ambil daftar transaksi simpanan nasabah berdasarkan ID nasabah
        $transaksiSimpanan = Simpanan::where('id_nasabah', $id)->get()->sortByDesc('created_at');
        // Ambil riwayat transaksi pinjaman nasabah berdasarkan ID nasabah
        $riwayatPinjaman = Pinjaman::where('id_nasabah', $id)->orderBy('created_at', 'desc')->get();
        $back = url()->previous();
        return view('nasabah.show', compact('data', 'dataTabungan', 'back', 'transaksiSimpanan', 'riwayatPinjaman', 'age'));
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
        $data = Nasabah::findOrFail($id);
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
    public function update(NasabahRequest $request, $id)
    {
        try {
            // Update the Nasabah
            $nasabah = Nasabah::findOrFail($id);
            $nasabah->update($request->validated());

            // Handle KTP image upload
            if ($request->hasFile('ktp_image_path')) {
                $imagePath = $request->file('ktp_image_path')->store('ktp_images/' . uniqid(), 'public');
                $nasabah->update(['ktp_image_path' => basename($imagePath)]);
            }

            return redirect('/nasabah')->with('success', 'Data Nasabah berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error while updating Nasabah data: ' . $e->getMessage());
            return redirect('/nasabah')->with('error', 'Terjadi kesalahan saat memperbarui data Nasabah. Silakan coba lagi.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Nasabah::destroy($id);
        return redirect('nasabah')->with('success', 'Data Berhasil di Hapus');
    }

    public function showTransactions($id)
    {
        // Cari nasabah berdasarkan ID
        $nasabah = Nasabah::find($id);
        if (!$nasabah) {
            return back()->with('warning', 'Nasabah tidak ditemukan.');
        }
        // Ambil daftar transaksi simpanan nasabah berdasarkan ID nasabah
        $transaksiSimpanan = Simpanan::where('id_nasabah', $id)->orderBy('created_at', 'desc')->get();

        return view('transaksi.index', compact('nasabah', 'transaksiSimpanan'));
    }
}
