<?php

namespace App\Http\Controllers;

use Carbon\Carbon;


use App\Models\Nasabah;
use App\Models\Simpanan;
use App\Models\BukuTabungan;
use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\NasabahRequest;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
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
        $data = new Nasabah();
        $back = url()->previous();
        return view('nasabah.add', compact('data', 'back'));
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NasabahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NasabahRequest $request)
    {
        try {
            // Wrap the database operations in a transaction
            DB::transaction(function () use ($request) {
            // Create and save a new Nasabah
            $nasabah = Nasabah::create($request->validated());
            });

            return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->route('nasabah.index')->with('error', 'Terjadi kesalahan saat membuat nasabah: ' . $e->getMessage());
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
        $data = Nasabah::with(['bukuTabungan', 'simpanan', 'pinjaman'])->findOrFail($id);
        $dataTabungan = $data->bukuTabungan;

        // Ambil umur
        $birthdate = Carbon::parse($data->date_of_birth);
        $currentDate = Carbon::now();
        $age = $birthdate->diffInYears($currentDate);

        // Ambil daftar transaksi simpanan nasabah berdasarkan ID nasabah
        $transaksiSimpanan = $data->simpanan->sortByDesc('created_at');

        // Ambil riwayat transaksi pinjaman nasabah berdasarkan ID nasabah
        $riwayatPinjaman = $data->pinjaman->sortByDesc('created_at');

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
                if ($nasabah->ktp_image_path) {
                    $oldImagePath = public_path('storage/ktp_images/' . $nasabah->ktp_image_path);

                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
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
            $nasabah = Nasabah::with(['pinjaman', 'simpanan', 'penarikan'])->find($id);

            if (!$nasabah) {
                // Redirect dengan pesan error jika Nasabah tidak ditemukan
                return redirect('/nasabah')->with('error', 'Nasabah tidak ditemukan.');
            }

            // Periksa apakah ada peminjaman yang belum lunas
            $hasUnpaidLoans = $nasabah->pinjaman->contains(function ($pinjaman) {
                return $pinjaman->status !== 'Lunas';
            });

            if ($hasUnpaidLoans) {
                // Redirect dengan pesan error jika ada pinjaman yang belum lunas
                return redirect('/nasabah')->with('error', 'Nasabah memiliki transaksi peminjaman yang belum lunas sehingga data nasabah tidak dapat diarsipkan.');
            }

            // Hapus semua data terkait Nasabah
            $nasabah->simpanan()->delete();
            $nasabah->penarikan()->delete();
            // $nasabah->angsuran()->delete();
            $nasabah->delete();

            DB::commit();
            return redirect('/nasabah')->with('success', 'Nasabah berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error while updating Nasabah data: ' . $e->getMessage());

            return redirect('/nasabah')->with('error', 'Terjadi kesalahan saat menghapus nasabah: ' . $e->getMessage());
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
        $transaksiSimpanan = Simpanan::where('nasabah_id', $id)->orderBy('created_at', 'desc')->get();

        return view('transaksi.index', compact('nasabah', 'transaksiSimpanan'));
    }

     /**
     * Display the transaction history of the specified nasabah.
     *
     * @param  int  $nasabah_id
     * @return \Illuminate\Http\Response
     */
    public function riwayatTransaksi($nasabah_id)
    {
        
        // $previousUrl = url()->previous();
        // $bukuTabungan = BukuTabungan::where('nasabah_id',$nasabah_id)->first();
        // // Ambil riwayat transaksi peminjaman nasabah berdasarkan ID nasabah
        // $riwayatTransaksi = RiwayatTransaksi::with('pegawai')->where('tabungan_id',
        // $bukuTabungan->id)->orderBy('created_at', 'desc')->paginate(10);
        // return view('transaksi.riwayat.riwayat', compact('riwayatTransaksi', 'previousUrl'));
        
        $nasabah = Nasabah::findOrFail($nasabah_id);
        $transaksiSimpanan = $nasabah->simpanan()->paginate(10);

        return view('nasabah.riwayatTransaksi', compact('nasabah', 'transaksiSimpanan'));
    }

    /**
     * Display the loan history of the specified nasabah.
     *
     * @param  int  $nasabah_id
     * @return \Illuminate\Http\Response
     */
    public function riwayatPinjaman($nasabah_id)
    {
        $nasabah = Nasabah::findOrFail($nasabah_id);
        $riwayatPinjaman = $nasabah->pinjaman->sortByDesc('created_at');

        return view('nasabah.riwayatPinjaman', compact('nasabah', 'riwayatPinjaman'));
    }

}
