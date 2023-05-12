<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departmens')->insert(
            [
                // PT KARYA PACIFIC TEKNIK
                [
                    'code' => 'PT-01',
                    'name' => 'Manager',
                    'description' => 'Departemen Manager',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-02',
                    'name' => 'Hrd',
                    'description' => 'Departemen Hrd',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-03',
                    'name' => 'Gudang/Logistics',
                    'description' => 'Departemen Gudang/Logistics',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-04',
                    'name' => 'Mekanik/ Mecanic',
                    'description' => 'Departemen Mekanik/ Mecanic',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-05',
                    'name' => 'Electric',
                    'description' => 'Departemen Electric',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-06',
                    'name' => 'Kebun',
                    'description' => 'Departemen Kebun',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-07',
                    'name' => 'Rep. Balon',
                    'description' => 'Departemen Rep. Balon',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-08',
                    'name' => 'Rep. Balon',
                    'description' => 'Departemen Rep. Balon',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-09',
                    'name' => 'Rep. Balon',
                    'description' => 'Departemen Rep. Balon',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-10',
                    'name' => 'Airbag',
                    'description' => 'Departemen Airbag',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-11',
                    'name' => 'Driver',
                    'description' => 'Departemen Driver',
                    'company_id' => 1,
                ],
                [
                    'code' => 'PT-12',
                    'name' => 'Operator',
                    'description' => 'Departemen Operator',
                    'company_id' => 1,
                ],

                // CV KARYA PACIFIC TEKNIK
                [
                    'code' => 'CV-01',
                    'name' => 'Manager',
                    'description' => 'Departemen Manager',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-02',
                    'name' => 'Ass Manager',
                    'description' => 'Departemen Ass Manager',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-03',
                    'name' => 'Hrd',
                    'description' => 'Departemen Hrd',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-04',
                    'name' => 'Pengawas/ Supervisor',
                    'description' => 'Departemen Pengawas/ Supervisor',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-05',
                    'name' => 'Acounting',
                    'description' => 'Departemen Acounting',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-06',
                    'name' => 'Marketing',
                    'description' => 'Departemen Marketing',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-07',
                    'name' => 'Hygiene',
                    'description' => 'Departemen Hygiene',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-08',
                    'name' => 'Bubut',
                    'description' => 'Departemen Bubut',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-09',
                    'name' => 'Mekanik/ Mecanic',
                    'description' => 'Departemen Mekanik/ Mecanic',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-10',
                    'name' => 'Electric',
                    'description' => 'Departemen Electric',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-11',
                    'name' => 'Operator',
                    'description' => 'Departemen Operator',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-12',
                    'name' => 'Welder',
                    'description' => 'Departemen Welder',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-13',
                    'name' => 'Fitter',
                    'description' => 'Departemen Fitter',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-14',
                    'name' => 'Helper',
                    'description' => 'Departemen Helper',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-16',
                    'name' => 'Kebun',
                    'description' => 'Departemen Kebun',
                    'company_id' => 2,
                ],
                [
                    'code' => 'CV-17',
                    'name' => 'Driver',
                    'description' => 'Departemen Driver',
                    'company_id' => 2,
                ],
            ],
        );
    }
}
