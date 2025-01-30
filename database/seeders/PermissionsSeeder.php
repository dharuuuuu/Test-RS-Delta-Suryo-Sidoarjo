<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'list roles', 'view roles', 'create roles', 'update roles', 'delete roles',
            'list permissions', 'view permissions', 'create permissions', 'update permissions', 'delete permissions',
            'list users', 'view users', 'create users', 'update users', 'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $dokterRole = Role::firstOrCreate(['name' => 'Dokter']);
        $apotekerRole = Role::firstOrCreate(['name' => 'Apoteker']);

        // Assign permissions
        $dokterRole->givePermissionTo(Permission::all()); // Dokter dapat semua permission
        $apotekerRole->givePermissionTo([
            'list users', 'view users', 'create users', 'update users', 'delete users'
        ]);

        // Assign roles to users
        $dokterUser = User::whereEmail('dokter@gmail.com')->first();
        if ($dokterUser) {
            $dokterUser->assignRole($dokterRole);
        }

        $apotekerUser = User::whereEmail('apoteker@gmail.com')->first();
        if ($apotekerUser) {
            $apotekerUser->assignRole($apotekerRole);
        }
    }
}
