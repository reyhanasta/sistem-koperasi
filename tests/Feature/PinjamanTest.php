<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nasabah;
use App\Models\Pegawai;
use App\Models\Pinjaman;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PinjamanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     /** @test */
     public function it_belongs_to_nasabah()
     {
         $nasabah = Nasabah::factory()->create();
         $pinjaman = Pinjaman::factory()->create(['nasabah_id' => $nasabah->id]);
 
         $this->assertInstanceOf(Nasabah::class, $pinjaman->nasabah);
         $this->assertEquals($pinjaman->nasabah->id, $nasabah->id);
     }
 
     /** @test */
     public function it_belongs_to_pegawai()
     {
         $pegawai = Pegawai::factory()->create();
         $pinjaman = Pinjaman::factory()->create(['id_pegawai' => $pegawai->id]);
 
         $this->assertInstanceOf(Pegawai::class, $pinjaman->pegawai);
         $this->assertEquals($pinjaman->pegawai->id, $pegawai->id);
     }
}
