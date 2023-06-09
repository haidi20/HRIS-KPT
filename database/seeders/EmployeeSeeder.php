<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Employee;
use Carbon\Carbon;

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
                $employee = new Employee([
                    "nip" => $data[1],
                    "nik" => $data[2],
                    "name" => $data[3],
                    "photo" => 'employee/default-icon.png',
                    "enter_date" => Carbon::now(),
                    "company_id" => $data[4],
                    "position_id" => $data[5],
                    // "finger_doc_1" => $data[6],
                ]);

                // Mengambil waktu pembuatan data dari entitas yang sesuai di database
                $existingEmployee = Employee::where('nip', $data[1])->first();
                if ($existingEmployee) {
                    $employee->enter_date = $existingEmployee->created_at;
                }

                $employee->save();
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
