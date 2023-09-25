<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use App\Models\Penarikan;

use App\Models\BukuTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



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
        $data = Nasabah::all()->sortByDesc('created_at');
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

     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string',
             'gender' => 'required|in:male,female',
             'phone' => 'required|string',
             'address' => 'required|string',
             'ktp' => 'required|string|unique:nasabahs,ktp',
             'date_of_birth' => 'required|date',
             'ktp_image_path' => 'image|mimes:jpeg,png,jpg,gif|max:20480', // Validasi gambar KTP
         ]);
 
         if ($validator->fails()) {
             return redirect('/nasabah/create')
                 ->withErrors($validator)
                 ->withInput();
         }
 
         DB::beginTransaction();
 
         try {
             // Create and save a new Nasabah
             $nasabah = Nasabah::create([
                 'name' => $request->input('name'),
                 'gender' => $request->input('gender'),
                 'phone' => $request->input('phone'),
                 'address' => $request->input('address'),
                 'ktp' => $request->input('ktp'),
                 'date_of_birth' => $request->input('date_of_birth'),
             ]);
 
             // Generate and save a new BukuTabungan
             $date = $request->input('date_of_birth');
             $formattedDate = date('md', strtotime($date));
             $padString = date('ymd') . $formattedDate;
             $point = $nasabah->id;
             $nomor_rekening = str_pad($point, 12, $padString, STR_PAD_LEFT);
 
             BukuTabungan::create([
                 'id_nasabah' => $nasabah->id,
                 'no_rek' => $nomor_rekening,
                 'balance' => 5000,
                 'status' => 'aktif',
             ]);
 
             // Save KTP image (if uploaded)
             if ($request->hasFile('ktp_image_path')) {
                 $imagePath = $request->file('ktp_image_path')->store('ktp_images/' . uniqid(), 'public');
                 $imageName = basename($imagePath);
                 $nasabah->update(['ktp_image_path' => $imageName]);
             }
 
             DB::commit();
 
             return redirect('/nasabah')->with('success', 'Data Nasabah beserta buku tabungannya berhasil di Tambahkan!');
         } catch (\Exception $e) {
             DB::rollBack();
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
        // Ambil daftar transaksi simpanan nasabah berdasarkan ID nasabah
        $transaksiSimpanan = Simpanan::where('id_nasabah', $id)->get()->sortByDesc('created_at');
        // Ambil riwayat transaksi pinjaman nasabah berdasarkan ID nasabah
        $riwayatPinjaman = Pinjaman::where('id_nasabah', $id)->orderBy('created_at', 'desc')->get();
        $back = url()->previous();
        return view('nasabah.show', compact('data', 'dataTabungan', 'back', 'transaksiSimpanan', 'riwayatPinjaman'));
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
    public function update(Request $request, $id)
    {
        try {
            $nasabah = Nasabah::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'gender' => 'required|in:male,female',
                'phone' => 'required|string',
                'address' => 'required|string',
                'ktp' => 'required|string',
                'date_of_birth' => 'required|date',
                'ktp_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar KTP
                'ktp' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{16}$/u', // Format KTP adalah 16 digit numerik, sesuaikan dengan format yang sesuai.
                ],
            ]);

            // Hapus gambar KTP lama jika ada
            if ($nasabah->ktp_image_path) {
                Storage::disk('public')->delete($nasabah->ktp_image_path);
            }

            // Simpan gambar KTP baru (jika diunggah)
            if ($request->hasFile('ktp_image')) {
                $imagePath = $request->file('ktp_image')->store('ktp_images', 'public');
                $validatedData['ktp_image_path'] = $imagePath;
            }

            // Update Nasabah data
            $nasabah->update($validatedData);
            return redirect('/nasabah')->with('success', 'Data Nasabah berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error while updating Nasabah data: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data Nasabah. Silakan coba lagi.']);
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
