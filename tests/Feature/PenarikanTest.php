<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\BukuTabungan;


class PenarikanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
      /** @test */
      public function it_belongs_to_buku_tabungan()
      {
          $bukuTabungan = BukuTabungan::factory()->create();
          $penarikan = Penarikan::factory()->create(['id_rekening' => $bukuTabungan->id]);
  
          $this->assertInstanceOf(BukuTabungan::class, $penarikan->bukuTabungan);
          $this->assertEquals($penarikan->bukuTabungan->id, $bukuTabungan->id);
      }
  
      /** @test */
      public function it_belongs_to_nasabah()
      {
          $nasabah = Nasabah::factory()->create();
          $penarikan = Penarikan::factory()->create(['nasabah_id' => $nasabah->id]);
  
          $this->assertInstanceOf(Nasabah::class, $penarikan->nasabah);
          $this->assertEquals($penarikan->nasabah->id, $nasabah->id);
      }
    
}
