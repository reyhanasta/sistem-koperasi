<?php

namespace Database\Seeders;

use App\Models\BukuTabungan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BukuTabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BukuTabungan::create([
            'no_rek' => '230916080911',
            'nasabah_id' => '1',
            'balance' => 1000000,
            'status' => 'aktif',
            'notes' => 'Catatan',
        ]);
    }
}
