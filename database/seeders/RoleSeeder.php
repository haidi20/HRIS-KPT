<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
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

        $permissionPrivate = Config("library.permission_private");
        $permissionAdmin = Permission::whereNotIn("name", $permissionPrivate)->pluck("name")->toArray();
        $permissionAdmin = array_map('strtolower', $permissionAdmin);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo($permissionAdmin);

        $roleHrd = Role::create(['name' => 'HRD']);
        $roleHrd->givePermissionTo(["lihat kasbon", "persetujuan kasbon"]);
    }
}
