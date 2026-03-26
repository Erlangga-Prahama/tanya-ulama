<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat roles
        Role::create(['name' => 'user']);
        Role::create(['name' => 'ustaz']);
        Role::create(['name' => 'ustazah']);
        Role::create(['name' => 'admin']);
        
        $this->command->info('Roles created successfully!');
    }
}
