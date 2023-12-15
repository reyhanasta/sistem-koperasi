<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pegawai;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PinjamanRequest;

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
        $riwayatPinjaman = Pinjaman::where('nasabah_id', $nasabah_id)->orderBy('created_at', 'desc')->get();

        return view('transaksi.pinjaman.riwayat', compact('nasabah', 'riwayatPinjaman', 'previousUrl'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = new Pinjaman();
        $nasabahList = Nasabah::all();
        $previousUrl = url()->previous();
        $confirmMessage = "Pastikan Data sudah di isi dengan benar, karena data transaksi tidak dapat di ubah lagi";

        return view('transaksi.pinjaman.add', compact('data', 'nasabahList', 'previousUrl', 'confirmMessage'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PinjamanRequest $request)
    {
        try {
            // Validasi data yang masuk telah dilakukan oleh PinjamanRequest
            $user = Auth::user();
            $pegawai = Pegawai::where('user_id', $user->id)->firstOrFail();

            $total_pembayaran = $request->jumlah_pinjaman * (1 - ($request->bunga / 100));
            $angsuran = $total_pembayaran / $request->jangka_waktu;

            Pinjaman::create([
                'nasabah_id' => $request->nasabah,
                'kode_pinjaman' => $this->generateTransactionCode(),
                'id_pegawai' => $pegawai->id,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'jumlah_pinjaman' => $request->jumlah_pinjaman,
                'jenis_pinjaman' => $request->jenis_pinjaman,
                'tujuan_pinjaman' => $request->tujuan_pinjaman,
                'jangka_waktu' => $request->jangka_waktu,
                'catatan' => $request->catatan,
                'angsuran' => $angsuran,
                'sisa_pinjaman' => $total_pembayaran,
                'total_pembayaran' => $total_pembayaran,
            ]);

            return redirect('/trx-pinjaman')->with('success', 'Data ditambahkan, buku tabungan nasabah diupdate.');
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data pinjaman: ' . $e->getMessage());
            return redirect('/trx-pinjaman')->with('error', 'Terjadi kesalahan saat menambahkan data Nasabah. Silakan coba lagi.');
        }
    }



    private function generateTransactionCode()
    {
        $now = now();
        $baseCode = "P{$now->format('ym')}";

        // Increment the transaction count
        $transactionCount = Pinjaman::withTrashed()->where('kode_pinjaman', 'like', "{$baseCode}%")->count() + 1;

        return "{$baseCode}" . str_pad($transactionCount, 3, '0', STR_PAD_LEFT);
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
            Pinjaman::findOrFail($id)->update(['status' => $newStatus]);

            return redirect('/trx-pinjaman')->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani kesalahan
            Log::error('Terjadi kesalahan saat memperbarui status pinjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status pinjaman. Silakan coba lagi.');
        }
    }


    public function lunasi($id)
    {
        try {
            // Update status pinjaman menjadi "Lunas" dan sisa_pinjaman menjadi 0
            Pinjaman::where('id', $id)
                ->update([
                    'status' => 'Lunas',
                    'sisa_pinjaman' => 0,
                    'jumlah_angsuran' => DB::raw('jumlah_angsuran + 1')
                ]);

            return redirect('/trx-pinjaman')->with('success', 'Pembayaran lunas berhasil.');
        } catch (\Exception $e) {
            // Tangani kesalahan
            Log::error('Terjadi kesalahan saat melakukan pembayaran lunas: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat melakukan pembayaran lunas. Silakan coba lagi.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the Pinjaman by ID and delete it
            Pinjaman::destroy($id);
            return redirect('/trx-pinjaman');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            Log::error('Terjadi kesalahan saat menghapus Pinjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus Pinjaman. Silakan coba lagi.');
        }
    }
}
