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
            ["name" => "Absensi", "description" => ""],
            ["name" => "Roster", "description" => ""],
            ["name" => "Kasbon", "description" => ""],
            // ["name" => "Surat Perintah Lembur", "description" => ""],
            ["name" => "Slip Gaji", "description" => ""],
            ["name" => "Penggajian", "description" => ""],
            ["name" => "Proyek", "description" => ""],
            ["name" => "Job Order", "description" => ""],
            // laporan
            ["name" => "Laporan Job Order", "description" => ""],
            ["name" => "Laporan Kasbon", "description" => ""],
            ["name" => "Laporan Surat Perintah Lembur", "description" => ""],
            // master
            // ["name" => "Jabatan", "description" => ""],
            ["name" => "Departemen", "description" => ""],
            ["name" => "Perusahaan", "description" => ""],
            ["name" => "Jenis Karyawan", "description" => ""],
            ["name" => "Kapal", "description" => ""],
            ["name" => "Lokasi", "description" => ""],
            ["name" => "Bahan", "description" => ""],
            ["name" => "Kategori Job Order", "description" => ""],
            ["name" => "Jadwal Kerja", "description" => ""],
            ["name" => "Jenis Pekerjaan", "description" => ""],
            ["name" => "Karyawan", "description" => ""],
            // setting
            ["name" => "Penyesuaian Gaji", "description" => "Manajemen penambahan dan pengurangan gaji karyawan"],
            ["name" => "Jam Kerja", "description" => "Manajemen Jam Kerja Karyawan"],
            ["name" => "Pengguna", "description" => "Manajemen Data Pengguna"],
            ["name" => "Hak Akses", "description" => "Manajemen Hak Akses berdasarkan grup user"],
            ["name" => "Fitur", "description" => "Manajemen Data Fitur"],
            ["name" => "Grup Pengguna", "description" => "Manajemen Data Grup Pengguna"],

        ]);
    }
}
