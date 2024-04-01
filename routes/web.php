<?php

use App\Http\Controllers\BukuTabunganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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
// Route::get('/', function () {
//     return view('welcome');
// });

// Semua rute yang memerlukan autentikasi dan verifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        // Profil
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('nasabah', NasabahController::class);
    Route::resource('master-jabatan', MasterJabatanController::class);
    Route::resource('trx-penarikan', PenarikanController::class);
    Route::resource('trx-angsuran', AngsuranController::class);
<<<<<<< HEAD
    Route::resource('trx-pinjaman', PinjamanController::class);
    Route::resource('trx-simpanan', SimpananController::class);
    // Pinjaman
    Route::put('/pinjaman/{id}/update-status/{newStatus}',[PinjamanController::class, 'updateStatus'])->name('pinjaman.updateStatus');
    Route::put('/pinjaman/{id}/lunasi', [PinjamanController::class,'lunasi'])->name('pinjaman.lunasi');
    Route::get('/pinjaman/{nasabah_id}', [PinjamanController::class,'riwayatPinjaman'])->name('pinjaman.riwayat');
    // Membuat Pinjaman
    Route::get('/trx-pinjaman/create', 'create')->name('pinjaman.create');

    // Saldo Nasabah
    Route::get('/saldoNasabah/{id}', [BukuTabunganController::class, 'getSaldo']);

   

    Route::controller(ProfileController::class)->group(function () {
        // Simpanan
=======
    Route::resource('trx-pinjaman',PinjamanController::class);
    Route::resource('trx-simpanan',SimpananController::class);
    // Saldo Nasabah
    Route::get('/saldoNasabah/{id}', [BukuTabunganController::class, 'getSaldo']);

    Route::controller(PinjamanController::class)->group(function () {
        // Pinjaman
        
        Route::put('/pinjaman/{id}/update-status/{newStatus}','updateStatus')->name('pinjaman.updateStatus');
        Route::put('/pinjaman/{id}/lunasi','lunasi')->name('pinjaman.lunasi');
        Route::get('/pinjaman/{nasabah_id}','riwayatPinjaman')->name('pinjaman.riwayat');
        // Membuat Pinjaman
        Route::get('/trx-pinjaman/create','create')->name('pinjaman.create');
    });

    Route::controller(ProfileController::class)->group(function () {
        // Simpanan
       
>>>>>>> 9b7266c69e6275ec34da2abc4910e09203d31551
        Route::get('/simpanan/{nasabah_id}','riwayatSimpanan')->name('simpanan.riwayat');
    });

    // Riwayat Transaksi
    Route::get('/riwayattransaksi/{nasabah_id}', [RiwayatTransaksiController::class, 'show'])->name('riwayatTransaksi');
});

Route::middleware(['auth','verified','role:admin'])->group(function(){

});

// Route::get('/ujicoba', function () {
//     return "hello world";
// })->middleware(['auth', 'verified', 'role:admin'])->name('ujicoba');

// //DASHBOARD
// Route::get('/',[DashboardController::class,'index'])->middleware('auth');
//LOGIN
// Route::get('/login',[LoginController::class,'index'])->name('login')->middleware('guest');
// Route::post('/login',[LoginController::class,'authenticate']);
// Route::post('/logout',[LoginController::class,'logout']);
//RESOURCE
// Route::middleware('auth','log.crud.activity')->group(function () {
// });

require __DIR__ . '/auth.php';
