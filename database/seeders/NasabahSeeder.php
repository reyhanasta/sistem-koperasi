<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nasabah::create([
        //     'name' => 'Putri Novia',
        //     'address' => 'Jalan Hangtuah Bukit Cipta Residence',
        //     'phone' => '087654321232',
        //     'date_of_birth' => '1998-11-28',
        //     'gender' => 'female',
        //     'ktp' => '1402010909970003',
        // ]);

        
        // Tambahkan lebih banyak data nasabah jika diperlukan
        Nasabah::factory()->count(50)->create();
    }
}
