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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('nasabah', NasabahController::class);
    // Route::resource('buku-tabungan', BukuTabunganController::class);
    Route::resource('master-jabatan', MasterJabatanController::class);
    Route::resource('trx-simpanan', SimpananController::class);
    Route::resource('trx-penarikan', PenarikanController::class);
    Route::resource('trx-pinjaman', PinjamanController::class);
    Route::resource('trx-angsuran', AngsuranController::class);

    Route::get('/saldoNasabah/{id}', [BukuTabunganController::class, 'getSaldo']);

    Route::put('/pinjaman/{id}/update-status/{newStatus}', [PinjamanController::class, 'updateStatus'])->name('pinjaman.updateStatus');
    Route::put('/pinjaman/{id}/lunasi', [PinjamanController::class, 'lunasi'])->name('pinjaman.lunasi');
    Route::get('/pinjaman/{nasabah_id}', [PinjamanController::class, 'riwayatPinjaman'])->name('pinjaman.riwayat');
    Route::get('/simpanan/{nasabah_id}', [SimpananController::class, 'riwayatSimpanan'])->name('simpanan.riwayat');
    Route::get('/riwayattransaksi/{nasabah_id}', [RiwayatTransaksiController::class, 'show'])->name('riwayatTransaksi');
});

Route::get('/ujicoba', function () {
    return "hello world";
})->middleware(['auth', 'verified', 'role:admin'])->name('ujicoba');

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
