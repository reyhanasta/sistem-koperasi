<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Simpanan;
use App\Models\BukuTabungan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SimpananRequest;
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
        try {
            // Retrieve all Simpanan data with related Nasabah, sorted by created_at in descending order
            $data = Simpanan::with('Nasabah')->latest('created_at')->get();
            $back = url()->previous();

            return view('transaksi.simpanan.list', compact('data', 'back'));
        } catch (\Exception $e) {
            // Handle any errors that occur
            Log::error('Terjadi kesalahan saat mengambil data Simpanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data Simpanan. Silakan coba lagi.');
        }
    }

    public function riwayatSimpanan($nasabah_id)
    {
        try {
            // Retrieve Nasabah data and their Simpanan transaction history by ID
            $nasabah = Nasabah::with('Simpanan')->find($nasabah_id);
            $previousUrl = url()->previous();

            if (!$nasabah) {
                return back()->with('warning', 'Nasabah tidak ditemukan.');
            }

            // Access the Simpanan transactions directly through the relationship
            $riwayatSimpanan = $nasabah->Simpanan->sortByDesc('created_at');

            return view('transaksi.simpanan.riwayat', compact('nasabah', 'riwayatSimpanan', 'previousUrl'));
        } catch (\Exception $e) {
            // Handle any errors that occur
            Log::error('Terjadi kesalahan saat mengambil riwayat Simpanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil riwayat Simpanan. Silakan coba lagi.');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
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
            return view('transaksi.simpanan.add', compact('data', 'kodeInput', 'nasabahList', 'previousUrl', 'confirmMessage'));
        } catch (\Exception $e) {
            // Handle any errors that occur
            Log::error('Terjadi kesalahan saat membuat transaksi Simpanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi Simpanan. Silakan coba lagi.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SimpananRequest $request)
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
        try {
            // Find the Simpanan by ID
            $simpanan = Simpanan::findOrFail($id);

            // Fetch the related Nasabah data
            $nasabah = Nasabah::findOrFail($simpanan->nasabah_id);

            // Pass the found Simpanan and Nasabah data to the view
            return view('transaksi.simpanan.show', compact('simpanan', 'nasabah'));
        } catch (\Exception $e) {
            // Handle the error, for example, log it
            Log::error('Error while showing Simpanan: ' . $e->getMessage());

            // Redirect back with an error message
            return back()->with('error', 'Error while showing Simpanan. Please try again.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            // Find the Simpanan by ID
            $data = Simpanan::findOrFail($id);

            // Fetch all Nasabah data
            $nasabahList = Nasabah::all();

            // Generate kode transaksi
            $kodeInput = $this->generateTransactionCode();

            //back URL
            $previousUrl = url()->previous();

            // Pass the found Simpanan and Nasabah data to the view
            return view('transaksi.simpanan.edit', compact('data', 'nasabahList', 'kodeInput','previousUrl'));
        } catch (\Exception $e) {
            // Handle the error, for example, log it
            Log::error('Error while editing Simpanan: ' . $e->getMessage());

            // Redirect back with an error message
            return back()->with('error', 'Error while editing Simpanan. Please try again.');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(SimpananRequest $request, $id)
    {
        try {
            // Find the Simpanan by ID
            $simpanan = Simpanan::findOrFail($id);

            // Get the validated data from the request
            $validatedData = $request->validated();

            // Update the Simpanan data with the validated values
            $simpanan->type = $validatedData['type'];
            $simpanan->amount = $validatedData['amount'];
            $simpanan->desc = $validatedData['desc'];

            // Save the updated Simpanan data
            $simpanan->save();

            // Redirect to the Simpanan details page with a success message
            return redirect('/trx-simpanan')->with('success', 'Simpanan data updated successfully.');
        } catch (\Exception $e) {
            // Handle the error, for example, log it
            Log::error('Error while updating Simpanan: ' . $e->getMessage());

            // Redirect back with an error message
            return back()->with('error', 'Error while updating Simpanan. Please try again.');
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
        //
    }

    private function generateTransactionCode()
    {
        $now = now();
        $yearMonth = $now->format('ym');
        $baseCode = "S{$yearMonth}";

        // Find the maximum existing code
        $latestCode = Simpanan::where('kode_simpanan', 'like', "{$baseCode}%")->max('kode_simpanan');

        // Extract the numeric part and increment it
        $transactionCount = (int)substr($latestCode, 6) + 1;

        return "{$baseCode}" . sprintf("%03d", $transactionCount);
    }
}
