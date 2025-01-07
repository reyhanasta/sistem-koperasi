<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'Muhammad Reyhan Perdana Asta',
            'username' => 'reyhanasta',
            'email' => 'astareyhan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');

        $admin1 = User::create([
            'name' => 'Admin 1',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
        ]);

        $admin1->assignRole('admin');

        $staff = User::create([
            'name' => 'Hilwa Asta',
            'username' => 'hilwaasta',
            'email' => 'astahilwa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('astahilwa'), // password
            'remember_token' => Str::random(10),
        ]);

        $staff->assignRole('staff-administrasi');

        $staff1 = User::create([
            'name' => 'Staff 1',
            'username' => 'staff',
            'email' => 'staff@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('staff'), // password
            'remember_token' => Str::random(10),
        ]);

        $staff1->assignRole('staff-keuangan');

        $nasabah = User::create([
            'name' => 'Putri Novia',
            'username' => 'putrinovia',
            'email' => 'putrinovia@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('putrinovia'), // password
            'remember_token' => Str::random(10),
        ]);

        $nasabah->assignRole('nasabah');
    }
}
