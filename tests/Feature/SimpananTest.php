<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Simpanan;
use App\Models\BukuTabungan;
use App\Models\Nasabah;


class SimpananTest extends TestCase
{
    use RefreshDatabase;

    protected $nasabah;
    protected $simpanan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->nasabah = Nasabah::factory()->create();
        $this->simpanan = Simpanan::factory()->create(['nasabah_id' => $this->nasabah->id]);
    }

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
        $this->assertInstanceOf(Nasabah::class, $this->simpanan->nasabah);
    }

    /** @test */
    public function it_has_a_relationship_with_buku_tabungan()
    {
        $this->assertInstanceOf(BukuTabungan::class, $this->simpanan->bukuTabungan);
    }

    /** @test */
    public function it_can_update_a_simpanan()
    {
        $simpanan = Simpanan::factory()->create();

        $simpanan->update([
            'amount' => 200000,
            'desc' => 'Updated deposit',
        ]);

        $this->assertDatabaseHas('simpanans', [
            'id' => $simpanan->id,
            'amount' => 200000,
            'desc' => 'Updated deposit',
        ]);
    }

    /** @test */
    public function it_can_delete_a_simpanan()
    {
        $simpanan = Simpanan::factory()->create();

        $simpanan->delete();

        $this->assertSoftDeleted('simpanans', [
            'id' => $simpanan->id,
        ]);
    }
}
