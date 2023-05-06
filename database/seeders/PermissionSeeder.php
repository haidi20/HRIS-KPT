<?php

namespace Database\Seeders;

use App\Models\Feature;
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
        $features = Feature::all();

        foreach ($features as $index => $feature) {
            $name = strtolower($feature->name);
            $featureDescription = str_replace('-', ' ', strtolower($feature->name));

            Permission::insert([
                ["name" => "lihat {$name}",  "description" => "lihat {$featureDescription}",  "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "tambah {$name}", "description" => "tambah {$featureDescription}", "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "ubah {$name}",   "description" => "ubah {$featureDescription}",   "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "hapus {$name}",  "description" => "hapus {$featureDescription}",  "guard_name" => "web", "feature_id" => $feature->id],
            ]);
        }

        $listAdds = [
            [
                "name" => "detail grup pengguna",
                "featurer_id" => 7,
            ],
            [
                "name" => "detail proyek",
                "featurer_id" => 8,
            ],
            [
                // untuk tombol detail job order di proyek
                "name" => "proyek job order",
                "featurer_id" => 8,
            ],
        ];

        foreach ($listAdds as $index => $add) {
            Permission::insert([
                "name" => $add["name"],  "description" => "",  "guard_name" => "web", "feature_id" => $add["featurer_id"],
            ]);
        }
    }
}
