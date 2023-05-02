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
            $featureDescription = str_replace('-', ' ', $feature->name);

            Permission::insert([
                ["name" => "lihat {$feature->name}",  "description" => "lihat {$featureDescription}",  "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "tambah {$feature->name}", "description" => "tambah {$featureDescription}", "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "edit {$feature->name}",   "description" => "edit {$featureDescription}",   "guard_name" => "web", "feature_id" => $feature->id],
                ["name" => "hapus {$feature->name}",  "description" => "hapus {$featureDescription}",  "guard_name" => "web", "feature_id" => $feature->id],
            ]);
        }
    }
}
