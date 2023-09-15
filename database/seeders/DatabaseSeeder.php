<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasterJabatan;

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
        
    }
}
