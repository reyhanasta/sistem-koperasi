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
            'email' => 'astareyhan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');

        $staff = User::create([
            'name' => 'Hilwa Asta',
            'email' => 'astahilwa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('astahilwa'), // password
            'remember_token' => Str::random(10),
        ]);

        $staff->assignRole('admin');

        $nasabah = User::create(attributes: [
            'name' => 'Putri Novia',
            'email' => 'putrinovia@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('putrinovia'), // password
            'remember_token' => Str::random(10),
        ]);

        $nasabah->assignRole('nasabah');
    }
}
