<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;

use App\Models\Pegawai;
use App\Models\Pinjaman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PinjamanService;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PinjamanRequest;
use App\Notifications\PeminjamanNotification;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Deklarasikan properti untuk menyimpan data yang dapat diakses di seluruh fungsi
    private $pinjaman;
    private $redirect;

    private $pinjamanServices;

    // Fungsi konstruktor untuk menginisialisasi nilai properti
    public function __construct(PinjamanService $pinjamanService, Pinjaman $pinjaman)
    {
        $this->redirect = '/trx/pinjaman'; // Ganti dengan nilai default yang sesuai
        $this->pinjamanServices = $pinjamanService; // Ganti dengan nilai default yang sesuai
        $this->pinjaman = $pinjaman; // Ganti dengan nilai default yang sesuai
    }

    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi yang belum dibaca
        $notifications = $user->unreadNotifications;
        // Menyimpan notifikasi dalam session
        session()->put('notifications', $notifications);
        //
        $data = Pinjaman::with('nasabah')
        ->orderByRaw("FIELD(status, 'validasi', 'diajukan') DESC") // Urutkan berdasarkan prioritas status
        ->orderBy('created_at', 'DESC') // Lalu urutkan berdasarkan waktu terbaru
        ->paginate(10); // Ambil semua data pinjaman dari database
        // dd($urlCreate);
        return view('transaksi.pinjaman.list', compact('data'));
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
            $code =  'PJ' . strtoupper(Str::random(6)); // Generate kode transaksi
            $totalBayar = $request->jumlah_pinjaman * (1 - ($request->bunga / 100));
            $angsuran = $totalBayar / $request->jangka_waktu;
            $this->pinjamanServices->store($request,$angsuran,$totalBayar,$code);
            
            return redirect($this->redirect)->with('success', 'Data ditambahkan, buku tabungan nasabah diupdate.');
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Terjadi kesalahan saat menyimpan data pinjaman: ' . $e->getMessage());
            return redirect($this->redirect)
            ->with('error', 'Terjadi kesalahan saat menambahkan data Nasabah. Silakan coba lagi.');
        }
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
            Pinjaman::findOrFail($id)->update([
                'status' => $newStatus,
                'tanggal_persetujuan' => now()
            ]);

            if($newStatus == 'disetujui'){
                // Ambil semua user dengan role admin menggunakan Spatie
                $admins = Role::findByName('admin')->users;   
                // Kirim notifikasi ke setiap admin
                foreach ($admins as $admin) {
                     // Tandai semua notifikasi sebagai dibaca
                     $admin->unreadNotifications()
                    ->where('data->peminjaman_id', $id)
                    ->each(function ($notification) {
                        $notification->markAsRead();
                    });
                }
            }
            

            return redirect($this->redirect)->with('success', 'Status berhasil diperbarui.');
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
               // Pinjaman::where('id', $id)
        //         ->update([
        //             'status' => 'Lunas',
        //             'sisa_pinjaman' => 0,
        //             'jumlah_angsuran' => DB::raw('jumlah_angsuran + 1')
        //         ]);

            $this->pinjaman->lunaskanTransaksi($id);
            

            return redirect($this->redirect)->with('success', 'Pembayaran lunas berhasil.');
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
            return redirect($this->redirect)->with('success', 'Data Pinjaman berhasil dihapus.');;
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            Log::error('Terjadi kesalahan saat menghapus Pinjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus Pinjaman. Silakan coba lagi.');
        }
    }
    public function pay(string $id)
    {
        try {
            
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            Log::error('Terjadi kesalahan saat menghapus Pinjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus Pinjaman. Silakan coba lagi.');
        }
    }
}
