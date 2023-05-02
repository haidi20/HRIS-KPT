<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Task;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::insert([
            ["name" => "Penyesuaian Gaji", "description" => "Manajemen penambahan dan pengurangan gaji karyawan"],
            ["name" => "Jam Kerja", "description" => "Manajemen Jam Kerja Karyawan"],
            ["name" => "Pengguna", "description" => "Manajemen Data Pengguna"],
            ["name" => "Hak Akses", "description" => "Manajemen Hak Akses berdasarkan grup user"],
        ]);
    }
}
