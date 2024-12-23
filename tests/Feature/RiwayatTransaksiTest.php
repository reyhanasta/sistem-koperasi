<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\RiwayatTransaksi;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RiwayatTransaksiTest extends TestCase
{
    public function test_can_create_riwayat_transaksi_with_valid_nominal()
    {
        $riwayatTransaksi = RiwayatTransaksi::create([
            'nominal' => 500000000,
            'saldo_akhir' => 1000000000,
            'nasabah_id' => 1,
            'tabungan_id' => 1,
            'id_pegawai' => 1,
        ]);

        $this->assertDatabaseHas('riwayat_transaksis', [
            'nominal' => 500000000,
        ]);
    }

    public function test_cannot_create_riwayat_transaksi_with_invalid_nominal()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nominal terlalu besar.');

        RiwayatTransaksi::create([
            'nominal' => 2000000000,
            'saldo_akhir' => 3000000000,
            'nasabah_id' => 1,
            'tabungan_id' => 1,
            'id_pegawai' => 1,
        ]);
    }
}
