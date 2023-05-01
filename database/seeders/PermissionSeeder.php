<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "penyesuaian gaji", "jam kerja", "pengguna", "hak akses",
        ];

        foreach ($permissions as $index => $permission) {
            $permissionDescription = str_replace('-', ' ', $permission);

            Permission::insert([
                ["name" => "lihat {$permission}",  "description" => "lihat {$permissionDescription}",  "guard_name" => "web", "task_id" => ($index + 1)],
                ["name" => "tambah {$permission}", "description" => "tambah {$permissionDescription}", "guard_name" => "web", "task_id" => ($index + 1)],
                ["name" => "edit {$permission}",   "description" => "edit {$permissionDescription}",   "guard_name" => "web", "task_id" => ($index + 1)],
                ["name" => "hapus {$permission}",  "description" => "hapus {$permissionDescription}",  "guard_name" => "web", "task_id" => ($index + 1)],
            ]);
        }
    }
}
