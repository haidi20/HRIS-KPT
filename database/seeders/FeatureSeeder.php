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
            ["name" => "Dashboard", "description" => "Manajemen Data Dashboard"],
            ["name" => "Penyesuaian Gaji", "description" => "Manajemen penambahan dan pengurangan gaji karyawan"],
            ["name" => "Jam Kerja", "description" => "Manajemen Jam Kerja Karyawan"],
            ["name" => "Pengguna", "description" => "Manajemen Data Pengguna"],
            ["name" => "Grup Pengguna", "description" => "Manajemen Data Grup Pengguna"],
            ["name" => "Hak Akses", "description" => "Manajemen Hak Akses berdasarkan grup user"],
            ["name" => "Fitur", "description" => "Manajemen Data Fitur"],
        ]);
    }
}
