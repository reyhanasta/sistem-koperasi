<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SqlMigrationController extends Controller
{
    public function index()
    {
        $back = url()->previous();
        return view('migrasi.index', compact('back'));
    }

    public function upload(Request $request)
    {
        // Validasi input
        $request->validate([
            'sql_file' => 'required|file|mimes:sql',
        ]);

        $file = $request->file('sql_file');
        $path = $file->storeAs('sql_temp', 'ibss_dump.sql');
        dd( $path);
        // Restore ke database sementara (pastikan DB temp_db tersedia)
        $restoreCommand = "mysql -u root -pYourPassword temp_db < " . storage_path("app/{$path}");
        exec($restoreCommand, $output, $status);

        if ($status === 0) {
            return redirect()->route('migrasi.index')->with('success', 'DB IBSS berhasil dimuat ke temp_db');
        } else {
            return redirect()->route('migrasi.index')->with('error', 'Gagal restore SQL file');
        }
    }

    public function migrateNasabah()
    {
        $nasabahs = DB::connection('mysql')->table('nasabah_old')
            ->whereNotNull('TGLLAHIR')
            ->get();
                

        foreach ($nasabahs as $data) {
        
            try {
                Nasabah::create([
                    'name' => $data->NAMA_NASABAH,
                    'address' => $data->ALAMAT,
                    'phone' => $data->TELPON,
                    'date_of_birth' => Carbon::parse($data->TGLLAHIR)->format('Y-m-d'),
                    // 'gender' => $data->JENIS_KELAMIN,
                    'status_verifikasi' => true, // Asumsi semua data yang dimigrasi sudah terverifikasi
                ]);
            } catch (\Exception $e) {
                Log::error("Gagal insert nasabah ID {$data->NASABAH_ID}: " . $e->getMessage());
            }
        }

        return redirect()->route('migrasi.index')->with('success', 'Migrasi nasabah berhasil!');
    }

}
