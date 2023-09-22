<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PinjamanRequest;

use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

    public function riwayatPinjaman($nasabah_id)
    {
        // Cari nasabah berdasarkan ID
        $nasabah = Nasabah::find($nasabah_id);
        $previousUrl = url()->previous();

        if (!$nasabah) {
            return back()->with('warning', 'Nasabah tidak ditemukan.');
        }

        // Ambil riwayat transaksi peminjaman nasabah berdasarkan ID nasabah
        $riwayatPinjaman = Pinjaman::where('id_nasabah', $nasabah_id)->orderBy('created_at', 'desc')->get();

        return view('transaksi.pinjaman.riwayat', compact('nasabah', 'riwayatPinjaman', 'previousUrl'));
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
    public function store(Request $request, PinjamanRequest $pinjamanRequest)
    {
        $nasabahNotFoundWarning = 'Nasabah tidak ditemukan. Mohon tambahkan terlebih dahulu.';
        $successMessage = 'Data ditambahkan, buku tabungan nasabah diupdate.';

        try {
            // Lakukan validasi data yang masuk
            $validatedData = $pinjamanRequest->validated();

            if (!$validatedData) {
                return back()->with('warning', $nasabahNotFoundWarning);
            }

            // Generate kode transaksi
            $kodeInput = $this->generateTransactionCode();

            // Mendapatkan ID pengguna yang sedang login
            $userId = Auth::id();

            // Mencari pegawai berdasarkan user_id
            $pegawai = Pegawai::where('user_id', $userId)->first();

            // Nilai total pembayaran
            $total_pembayaran = $request->jumlah_pinjaman * (1 - ($request->bunga / 100));

            // Nilai total pembayaran
            $angsuran = $total_pembayaran / $request->jangka_waktu;

            // Simpan data pinjaman
            $data = new Pinjaman();
            $data->id_nasabah = $request->nasabah;
            $data->kode_pinjaman = $kodeInput;
            $data->id_pegawai = $pegawai->id;
            $data->tanggal_pengajuan = $request->tanggal_pengajuan;
            $data->jumlah_pinjaman = $request->jumlah_pinjaman;
            $data->jenis_pinjaman = $request->jenis_pinjaman;
            $data->tujuan_pinjaman = $request->tujuan_pinjaman;
            $data->jangka_waktu = $request->jangka_waktu;
            $data->bunga = $request->bunga;
            $data->catatan = $request->catatan;
            $data->angsuran = $angsuran;
            $data->sisa_pinjaman = $total_pembayaran;
            $data->total_pembayaran = $total_pembayaran;

            $data->save();

            return redirect('/trx-pinjaman')->with('success', $successMessage);
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data pinjaman: ' . $e->getMessage());
            // Tangani kesalahan di sini, misalnya, log kesalahan
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }


    private function generateTransactionCode()
    {
        $now = now();
        $year = $now->format('y');
        $month = $now->format('m');
        $baseCode = "P{$year}{$month}";

        // Mengecek apakah kode sudah terdaftar di database
        $existingCount = Pinjaman::where('kode_pinjaman', 'like', "{$baseCode}%")->count();

        // Menghasilkan kode dengan nomor urut yang sesuai
        $transactionCount = $existingCount + 1;

        return $baseCode . sprintf("%03d", $transactionCount);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pinjaman = Pinjaman::findOrFail($id);
        $previousUrl = url()->previous();
        return view('transaksi.pinjaman.show', compact('pinjaman', 'previousUrl'));
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

    public function updateStatus($id, $newStatus)
    {
        try {
            $pinjaman = Pinjaman::findOrFail($id);

            // Lakukan validasi status yang sah di sini, jika perlu
            // Misalnya, Anda ingin memeriksa apakah $newStatus adalah status yang valid
            $pinjaman->status = $newStatus;
            $pinjaman->save();

            return redirect('/trx-pinjaman')->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani kesalahan
            Log::error('Terjadi kesalahan saat memperbarui status pinjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status pinjaman. Silakan coba lagi.');
        }
    }

    public function lunasi(Request $request, $id)
    {
        // Cari pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);

        // Lakukan validasi, misalnya, pastikan status pinjaman adalah "Proses Angsuran"

        // Update status pinjaman menjadi "Lunas"
        $pinjaman->status = 'Lunas';
        $pinjaman->sisa_pinjaman = 0; // Jika ingin mengatur sisa_pinjaman menjadi 0
        $pinjaman->jumlah_angsuran += 1; // Melakukan 1x angsuran lunas
        $pinjaman->save();

        // Redirect atau kirim respons sesuai dengan kebutuhan Anda
        return redirect('/trx-pinjaman')->with('success', 'Pembayaran lunas berhasil.');
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
