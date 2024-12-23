<?php

namespace Database\Seeders;

use App\Models\BukuTabungan;
use App\Models\User;
use App\Models\MasterJabatan;
use App\Models\Pegawai;
use App\Models\Nasabah;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //USER SEEDER
        $this->call(RolePermissionSeeder::class);
        //USER SEEDER
        $this->call(UserSeeder::class);
        //JABATAN SEEDER
        $this->call(MasterJabatanSeeder::class);
        //PEGAWAI SEEDER
        $this->call(PegawaiSeeder::class);
        //NASABAH SEEDER
        $this->call(NasabahSeeder::class);
        //NASABAH SEEDER
        $this->call(BukuTabunganSeeder::class);
       
    }
}
