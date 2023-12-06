<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Membuat role
        Role::create(['name' => 'nasabah']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'admin']);

        // Membuat permission
        Permission::create(['name' => 'edit-nasabah']);

        // Memberikan permission ke role yang sesuai
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('edit-nasabah');
    }
}
