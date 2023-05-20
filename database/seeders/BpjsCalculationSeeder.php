<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BpjsCalculationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bpjs_calculations')->insert(
            [
                [
                    'name' => 'Hari Tua (HT)',
                    'company_percent' => '3,70',
                    'employee_percent' => '2,00',
                    'company_nominal' => '',
                    'employee_nominal' => '',
                ],
                [
                    'name' => 'Kecelakaan (JKK)',
                    'company_percent' => '1,74',
                    'employee_percent' => '0,00',
                    'company_nominal' => '',
                    'employee_nominal' => '',
                ],
                [
                    'name' => 'Kematian (JKM)',
                    'company_percent' => '0,30',
                    'employee_percent' => '0,00',
                    'company_nominal' => '',
                    'employee_nominal' => '',
                ],
                [
                    'name' => 'Pensiun (JP)',
                    'company_percent' => '2,00',
                    'employee_percent' => '1,00',
                    'company_nominal' => '',
                    'employee_nominal' => '',
                ],
                [
                    'name' => 'Kesehatan (BPJS)',
                    'company_percent' => '4,00',
                    'employee_percent' => '1,00',
                    'company_nominal' => '',
                    'employee_nominal' => '',
                ],
            ],
        );
    }
}
