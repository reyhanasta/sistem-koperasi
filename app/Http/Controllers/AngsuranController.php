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
        $successMessage = 'Data angsuran berhasil ditambahkan, dan data pinjaman diupdate.';
    
        // Validasi input
        $validated = $request->validate([
            'id_pinjaman' => 'required|exists:pinjamen,id',
        ]);
    
        try {
            // Mulai transaksi database
            DB::beginTransaction();
            // Cari pinjaman berdasarkan ID
            $pinjaman = Pinjaman::findOrFail($validated['id_pinjaman']);
          
    
            // Validasi tambahan: pastikan pinjaman dalam status tertentu, misalnya 'Proses Angsuran'
            if (!in_array($pinjaman->status, ['disetujui','berlangsung'])) {
                return back()->with('error', 'Pinjaman tidak dapat diangsur pada status ini.');
            }
            // Hitung jumlah angsuran harian dan sisa pinjaman
            $angsuranHarian = (float) $pinjaman->angsuran;
            $sisaPinjaman = (float) $pinjaman->sisa_pinjaman;
            
            // Update status pinjaman berdasarkan sisa pinjaman
            if ($sisaPinjaman <= $angsuranHarian) {
                $pinjaman->status = 'lunas';
                $pinjaman->sisa_pinjaman = 0;
            } else {
                $pinjaman->sisa_pinjaman -= $angsuranHarian;
                $pinjaman->jumlah_angsuran += 1;
                $pinjaman->status = 'berlangsung';
            }
            
            // dd($pinjaman->status);
            // Simpan perubahan pada pinjaman
            $pinjaman->save();
    
            // Simpan data angsuran
            Angsuran::create([
                'id_pinjaman' => $pinjaman->id,
                'nasabah_id' => $pinjaman->nasabah_id,
                'jumlah_angsuran' => $angsuranHarian,
                'tanggal_angsuran' => now(),
            ]);
    
            // Commit transaksi database jika semua berhasil
            DB::commit();
    
            return redirect('/trx/pinjaman')->with('success', $successMessage);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data angsuran: ' . $e->getMessage());
    
            return back()->with('error', 'Terjadi kesalahan saat menambahkan angsuran.');
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
