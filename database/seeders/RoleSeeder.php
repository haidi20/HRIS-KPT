<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        $roleSuperAdmin = Role::create(['name' => 'Admin']);
        $roleSuperAdmin->givePermissionTo("lihat dashboard");

        // $tRole->givePermissionTo(["lihat {$menu}"]);
    }
}
