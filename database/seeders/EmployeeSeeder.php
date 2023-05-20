<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bumdes::truncate();

        $csvFile = fopen(base_path("database/data/employee.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Employee::create([
                    "nip" => $data[1],
                    "nik" => $data[2],
                    "name" => $data[3],
                    "company_id" => $data[4],
                    "position_id" => $data[5],
                    "finger_doc_1" => $data[6],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
