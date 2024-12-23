<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Simpanan;
use App\Models\BukuTabungan;
use App\Models\Nasabah;


class SimpananTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_simpanan()
    {
        $simpanan = Simpanan::create([
            'id_rekening' => 1,
            'nasabah_id' => 1,
            'kode_simpanan' => 'KS123456',
            'type' => 'deposit',
            'amount' => 100000,
            'desc' => 'Initial deposit',
        ]);

        $this->assertDatabaseHas('simpanans', [
            'id_rekening' => 1,
            'nasabah_id' => 1,
            'kode_simpanan' => 'KS123456',
            'type' => 'deposit',
            'amount' => 100000,
            'desc' => 'Initial deposit',
        ]);
    }

    /** @test */
    public function it_has_a_relationship_with_nasabah()
    {
        $simpanan = Simpanan::factory()->create();
        $this->assertInstanceOf(Nasabah::class, $simpanan->nasabah);
    }

    /** @test */
    public function it_has_a_relationship_with_buku_tabungan()
    {
        $simpanan = Simpanan::factory()->create();
        $this->assertInstanceOf(BukuTabungan::class, $simpanan->bukuTabungan);
    }
}
