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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan Permissions
        $permissions = [
            'manage master data',
            'manage users',
            'manage roles',
            'manage learning materials',
            'manage assignments',
            'manage grades',
            'view learning materials',
            'submit assignments',
            'view grades',
            'pay invoices'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Roles dan Assign Permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        // Super Admin gets all permissions via Gate::before in AuthServiceProvider or explicitly
        $superAdmin->syncPermissions(Permission::all());

        $guru = Role::firstOrCreate(['name' => 'guru']);
        $guru->syncPermissions([
            'manage learning materials',
            'manage assignments',
            'manage grades'
        ]);

        $murid = Role::firstOrCreate(['name' => 'murid']);
        $murid->syncPermissions([
            'view learning materials',
            'submit assignments',
            'view grades',
            'pay invoices'
        ]);
    }
}
