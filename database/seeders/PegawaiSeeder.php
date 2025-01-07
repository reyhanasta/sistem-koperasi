<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::create([
            'name' => 'Muhammad Reyhan Perdana Asta',
            'email' => 'astareyhan@gmail.com',
            'user_id' => 1,
            'master_jabatan_id' => 1,
            'gaji' => 1000000,
            'gender' => 'male',
            'join_date' => now()
        ]);

        Pegawai::create([
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'user_id' => 3,
            'master_jabatan_id' => 1,
            'gaji' => 1000000,
            'gender' => 'male',
            'join_date' => now()
        ]);
        
        Pegawai::create([
            'name' => 'Hilwa Puti Imani Asta',
            'email' => 'astahilwa@gmail.com',
            'user_id' => 2,
            'master_jabatan_id' => 2,
            'gaji' => 1000000,
            'gender' => 'female',
            'join_date' => now()
        ]);

        Pegawai::create([
            'name' => 'Staff 1',
            'email' => 'staff@gmail.com',
            'user_id' => 4,
            'master_jabatan_id' => 2,
            'gaji' => 1000000,
            'gender' => 'female',
            'join_date' => now()
        ]);

        Pegawai::create([
            'name' => 'Staff Berhenti',
            'email' => 'staffberhenti@gmail.com',
            'user_id' => 5,
            'master_jabatan_id' => 2,
            'gaji' => 1000000,
            'gender' => 'male',
            'join_date' => now(),
            'status' => 'berhenti'
        ]);
    }
}
