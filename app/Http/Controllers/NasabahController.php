<?php

namespace App\Http\Controllers;

use Carbon\Carbon;


use App\Models\Nasabah;
use App\Models\Angsuran;
use App\Models\Pinjaman;

use App\Models\Simpanan;
use App\Models\Penarikan;
use App\Models\BukuTabungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\NasabahRequest;




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
                    $imagePath = $request->file('ktp_image_path')->store('ktp_images/', 'public');
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
    public function update(NasabahRequest $request, Nasabah $nasabah)
    {
        try {
            // Hapus gambar lama jika ada yang baru diunggah
            if ($request->hasFile('ktp_image_path')) {
                $oldImagePath = public_path('storage/ktp_images/' . $nasabah->ktp_image_path);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Simpan gambar KTP yang baru
                $imagePath = $request->file('ktp_image_path')->store('ktp_images/', 'public');
                $imageName = basename($imagePath);
                $nasabah->update(['ktp_image_path' => $imageName]);
            }

            // Update data Nasabah lainnya
            $nasabah->update($request->except('ktp_image_path'));

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
        DB::beginTransaction();

        try {
            // Cari Nasabah berdasarkan ID
            $nasabah = Nasabah::findOrFail($id);

            // Pengecekan apakah Nasabah memiliki transaksi tertentu
            if (
                $nasabah->simpanan()->exists() ||
                $nasabah->pinjaman()->exists()
            ) {
                // Nasabah memiliki transaksi, maka arsipkan semua transaksi terkait Nasabah
                Simpanan::where('id_nasabah', $id)->update(['diarsipkan' => true]);
                Pinjaman::where('id_nasabah', $id)->update(['diarsipkan' => true]);
                // Angsuran::where('id_nasabah', $id)->update(['diarsipkan' => true]);
                // Penarikan::where('id_nasabah', $id)->update(['diarsipkan' => true]);

                // Hapus gambar KTP (jika ada)
                if ($nasabah->ktp_image_path) {
                    $ktpImagePath = public_path('storage/ktp_images/' . $nasabah->ktp_image_path);
                    if (file_exists($ktpImagePath)) {
                        unlink($ktpImagePath);
                    }
                }

                // Mengarsipkan Nasabah
                $nasabah->delete();

                // Commit transaksi jika semuanya berhasil
                DB::commit();

                // Redirect kembali ke halaman daftar Nasabah dengan pesan sukses
                return redirect('/nasabah')->with('success', 'Data Nasabah berhasil diarsipkan.');
            } else {
                // Nasabah tidak memiliki transaksi, tidak bisa diarsipkan
                // Redirect kembali ke halaman daftar Nasabah dengan pesan kesalahan
                return redirect('/nasabah')->with('error', 'Nasabah tidak memiliki transaksi yang dapat diarsipkan.');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            Log::error('Error while archiving Nasabah: ' . $e->getMessage());
            return redirect('/nasabah')->with('error', 'Terjadi kesalahan saat mengarsipkan Nasabah. Silakan coba lagi.');
        }
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

    function generateAccountNumber($nasabahId, $dateOfBirth)
    {
        // Format nomor rekening sesuai dengan kebutuhan Anda
        // Misalnya, Anda ingin format nomor rekening: "N000012345678"

        // Dapatkan tanggal lahir dalam format "ymd"
        $formattedDate = date('ymd', strtotime($dateOfBirth));

        // Ambil lima digit pertama dari ID nasabah dan tambahkan nol di depan jika perlu
        $nasabahIdPart = str_pad($nasabahId, 5, '0', STR_PAD_LEFT);

        // Gabungkan semuanya menjadi nomor rekening
        $accountNumber = "N" . $nasabahIdPart . $formattedDate;

        return $accountNumber;
    }
}
