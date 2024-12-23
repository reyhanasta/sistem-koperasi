<?php

namespace Database\Seeders;

use App\Models\MasterJabatan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterJabatan::create(['name' => 'Staff Administrasi']);
        MasterJabatan::create(['name' => 'Staff Keuangan']);
    }
}
