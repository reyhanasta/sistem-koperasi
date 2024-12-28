<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuTabunganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\RiwayatTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Semua rute yang memerlukan autentikasi dan verifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Saldo Nasabah
    Route::get('/saldoNasabah/{id}', [BukuTabunganController::class, 'getSaldo']);
    //Pinjaman Group
    Route::controller(PinjamanController::class)->group(function () {
        // Riwayat Transaksi Peminjaman
        Route::get('/pinjaman/{nasabah_id}','riwayatPinjaman')->name('pinjaman.riwayat');
        // Membuat Pinjaman
        // Route::get('/trx-pinjaman/create','create')->name('pinjaman.create');
    });

    //Simpanan Group
    Route::controller(ProfileController::class)->group(function () {
        // Simpanan
        Route::get('/simpanan/{nasabah_id}','riwayatSimpanan')->name('simpanan.riwayat');
    });

    // Riwayat Transaksi Simpanan dan Angsuran
    Route::get('/riwayat-mutasi/{nasabah_id}', [RiwayatTransaksiController::class, 'show'])->name('riwayatTransaksi');

    // Rute khusus untuk riwayat transaksi
    Route::get('nasabah/{nasabah_id}/riwayat-transaksi', [NasabahController::class, 'riwayatTransaksi'])->name('riwayatTransaksi');



//Role : Admin
//Rute khusus Admin
Route::middleware('role:admin')->group(function(){
    Route::controller(PinjamanController::class)->group(function () {
        // Pinjaman
        Route::put('/pinjaman/{id}/update-status/{newStatus}','updateStatus')->name('pinjaman.updateStatus');
        Route::put('/pinjaman/{id}/lunasi','lunasi')->name('pinjaman.lunasi');
        Route::put('/pinjaman/{id}/pay','pay')->name('pinjaman.pay');
        Route::resource('master-jabatan', MasterJabatanController::class);
        Route::resource('pegawai', PegawaiController::class);
    });
});

//Role : Admin & Staff
//Rute Khusus Staff
Route::middleware('role:admin|staff')->group(function(){
    // Resource routes
    Route::resource('nasabah', NasabahController::class);
    Route::post('/withdraw', [PenarikanController::class, 'withdraw'])->name('withdraw');
    Route::controller(PinjamanController::class)->prefix('trx')->group(function () {
        // Pinjaman
        Route::resource('penarikan', PenarikanController::class);
        Route::resource('angsuran', AngsuranController::class);
        Route::resource('pinjaman',PinjamanController::class);
        Route::resource('simpanan',SimpananController::class);
        // Route::get('pinjaman/create','create')->name('pinjaman.create');
    });
});

});

// Route::get('/',[DashboardController::class,'index'])->middleware('auth');

//LOGIN
// Route::get('/login',[LoginController::class,'index'])->name('login')->middleware('guest');
// Route::post('/login',[LoginController::class,'authenticate']);
// Route::post('/logout',[LoginController::class,'logout']);

//RESOURCE
// Route::middleware('auth','log.crud.activity')->group(function () {
// });

require __DIR__ . '/auth.php';
