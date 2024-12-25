<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nasabah;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AngsuranTest extends TestCase
{
    

     /** @test */
     public function it_can_record_angsuran_payment()
     {
         $nasabah = Nasabah::factory()->create();
         $pinjaman = Pinjaman::factory()->create(['nasabah_id' => $nasabah->id]);
         $angsuranAmount = 500000;
 
         $angsuran = Angsuran::factory()->create([
             'id_pinjaman' => $pinjaman->id,
             'jumlah_angsuran' => $angsuranAmount,
             'tanggal_angsuran' => now(),
             'status' => 'Belum Lunas',
         ]);
 
         $this->assertInstanceOf(Angsuran::class, $angsuran);
         $this->assertEquals($angsuran->id_pinjaman, $pinjaman->id);
         $this->assertEquals($angsuran->jumlah_angsuran, $angsuranAmount);
         $this->assertEquals($angsuran->status, 'Belum Lunas');
     }


}
