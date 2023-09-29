<?php

namespace Database\Seeders;

use App\Models\BukuTabungan;
use App\Models\User;
use App\Models\MasterJabatan;
use App\Models\Pegawai;
use App\Models\Nasabah;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        //JABATAB SEEDER
        MasterJabatan::create(['name' => 'Staff Administrasi']);
        MasterJabatan::create(['name' => 'Staff Keuangan']);
        //JABATAB SEEDER
        Pegawai::create([
            'name' => 'Muhammad Reyhan Perdana Asta',
            'email' => 'reyhan.perdana48@example.com',
            'user_id' => 1,
            'position' => 'Staff',
            'gaji' => 1000000,
            'gender' => 'male',
            'join_date' => now()
        ]);
        Nasabah::create([
            'name' => 'Putri Novia',
            'address' => 'Jalan Hangtuah Bukit Cipta Residence',
            'phone' => '087654321232',
            'date_of_birth' => '1998-11-28',
            'gender' => 'female',
            'ktp' => '1402010909970003',
        ]);
        BukuTabungan::create([
            'no_rek' => '230916080911',
            'nasabah_id' => '1',
            'balance' => 1000000,
            'status' => 'aktif',
            'notes' => 'Catatan',
        ]);
        
    }
}
