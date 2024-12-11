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
        Permission::create(['name' => 'add-nasabah']);
        Permission::create(['name' => 'edit-nasabah']);
        Permission::create(['name' => 'delete-nasabah']);
        Permission::create(['name' => 'detail-nasabah']);
        
        Permission::create(['name' => 'add-simpanan']);
        Permission::create(['name' => 'edit-simpanan']);
        Permission::create(['name' => 'delete-simpanan']);
        Permission::create(['name' => 'detail-simpanan']);

        // Memberikan permission ke role yang sesuai
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo(['add-nasabah','edit-nasabah']);
    }
}
