<?php

namespace Database\Seeders;


use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::insert([
            ["title" => "Penyesuaian Gaji", "description" => "Manajemen penambahan dan pengurangan gaji karyawan"],
            ["title" => "Jam Kerja", "description" => "Manajemen Jam Kerja Karyawan"],
            ["title" => "Pengguna", "description" => "Manajemen Data Pengguna"],
            ["title" => "Hak Akses", "description" => "Manajemen Hak Akses berdasarkan grup user"],
        ]);
    }
}
