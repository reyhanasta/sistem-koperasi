<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjaman extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai','id');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class);
    }

    public function buatPinjaman($request,$angsuran,$totalBayar,$code,$pegawai){
        return Pinjaman::create([
            'nasabah_id' => $request->nasabah,
            'kode_pinjaman' => $code,
            'id_pegawai' => $pegawai->id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'jenis_pinjaman' => $request->jenis_pinjaman,
            'tujuan_pinjaman' => $request->tujuan_pinjaman,
            'jangka_waktu' => $request->jangka_waktu,
            'catatan' => $request->catatan,
            'angsuran' => $angsuran,
            'sisa_pinjaman' => $totalBayar,
            'total_pembayaran' => $totalBayar,
        ]);
    }

    public function lunaskanTransaksi($id){
        dd('ada');
     
        $pinjaman = Pinjaman::find($id); // Gantilah $id dengan nilai yang sesuai
        // Memaksimalkan jumlah angsuran
        $pinjaman->jumlah_angsuran = $pinjaman->jangka_waktu;
        // Mengubah nilai kolom 'status'
        $pinjaman->status = 'lunas';
        // Mengubah nilai kolom 'sisa_pinjaman'
        $pinjaman->sisa_pinjaman = 0;
        // Mengubah nilai kolom 'sisa_pinjaman'
        $pinjaman->tanggal_pelunasan = now();

        // Menyimpan perubahan
        $pinjaman->save();
    }
}
