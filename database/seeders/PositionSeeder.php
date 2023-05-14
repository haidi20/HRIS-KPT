<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert(
            [
                // PT KARYA PACIFIC TEKNIK SHIPYARD
                // Pengawas/ Supervisor
                [
                    'name' => 'Pengawas',
                    'description' => 'Pengawas',
                    'departmen_id' => 1,
                ],
                [
                    'name' => 'Ass Mekanik',
                    'description' => 'Ass Mekanik',
                    'departmen_id' => 1,
                ],
                [
                    'name' => 'QC',
                    'description' => 'Quality Control',
                    'departmen_id' => 1,
                ],
                // HRD
                [
                    'name' => 'HRD',
                    'description' => 'HRD',
                    'departmen_id' => 2,
                ],
                // Gudang/ Logistics
                [
                    'name' => 'Logistics',
                    'description' => 'Logistics',
                    'departmen_id' => 3,
                ],
                // Mekanik
                [
                    'name' => 'Mekanik',
                    'description' => 'Mekanik',
                    'departmen_id' => 4,
                ],
                [
                    'name' => 'Help Mekanik',
                    'description' => 'Help Mekanik',
                    'departmen_id' => 4,
                ],
                // Electric
                [
                    'name' => 'Electric',
                    'description' => 'Electric',
                    'departmen_id' => 5,
                ],
                // Kebun
                [
                    'name' => 'Kebun',
                    'description' => 'Kebun',
                    'departmen_id' => 6,
                ],
                [
                    'name' => 'Helper',
                    'description' => 'Helper',
                    'departmen_id' => 6,
                ],
                // Rep. Balon
                [
                    'name' => 'Rep. Balon',
                    'description' => 'Rep. Balon',
                    'departmen_id' => 7,
                ],
                // Airbag
                [
                    'name' => 'Airbag',
                    'description' => 'Airbag',
                    'departmen_id' => 8,
                ],
                // Driver
                [
                    'name' => 'Driver',
                    'description' => 'Driver',
                    'departmen_id' => 9,
                ],
                // Operator
                [
                    'name' => 'Operator',
                    'description' => 'Operator',
                    'departmen_id' => 10,
                ],
                [
                    'name' => 'Kepala Bubut',
                    'description' => 'Kepala Bubut',
                    'departmen_id' => 19,
                ],
                [
                    'name' => 'Bubut',
                    'description' => 'Bubut',
                    'departmen_id' => 19,
                ],

                // CV KARYA PACIFIC TEKNIK SHIPYARD
                // Manager
                // [
                //     'name' => 'Manager',
                //     'description' => 'Manager',
                //     'departmen_id' => 11,
                // ],
                // // Ass Manager
                // [
                //     'name' => 'Pengawas',
                //     'description' => 'Pengawas',
                //     'departmen_id' => 12,
                // ],
                // [
                //     'name' => 'QC',
                //     'description' => 'QC',
                //     'departmen_id' => 12,
                // ],
                // // HRD
                // [
                //     'name' => 'HRD',
                //     'description' => 'HRD',
                //     'departmen_id' => 13,
                // ],
                // // Pengawas/Supervisor
                // [
                //     'name' => 'Pengawas/Supervisor',
                //     'description' => 'Pengawas/Supervisor',
                //     'departmen_id' => 14,
                // ],
                // // Acounting
                // [
                //     'name' => 'Head of Acounting',
                //     'description' => 'Head of Acounting',
                //     'departmen_id' => 15,
                // ],
                // [
                //     'name' => 'Acounting',
                //     'description' => 'Acounting',
                //     'departmen_id' => 15,
                // ],
                // [
                //     'name' => 'Purchasing',
                //     'description' => 'Purchasing',
                //     'departmen_id' => 15,
                // ],
                // [
                //     'name' => 'Cashier',
                //     'description' => 'Cashier',
                //     'departmen_id' => 15,
                // ],
                // [
                //     'name' => 'Admin',
                //     'description' => 'Admin',
                //     'departmen_id' => 15,
                // ],
                // [
                //     'name' => 'Admin A/R',
                //     'description' => 'Admin A/R',
                //     'departmen_id' => 15,
                // ],
                // // Marketing
                // [
                //     'name' => 'Marketing',
                //     'description' => 'Marketing',
                //     'departmen_id' => 16,
                // ],
                // // Hygiene
                // [
                //     'name' => 'Office Girl',
                //     'description' => 'office Girl',
                //     'departmen_id' => 17,
                // ],
                // // Gudang
                // [
                //     'name' => 'Head of Warehouse',
                //     'description' => 'Head of Warehouse',
                //     'departmen_id' => 18,
                // ],
                // [
                //     'name' => 'Adm. Warehouse',
                //     'description' => 'Adm. Warehouse',
                //     'departmen_id' => 18,
                // ],
                // // Bubut
                // [
                //     'name' => 'Kepala Bubut',
                //     'description' => 'Kepala Bubut',
                //     'departmen_id' => 19,
                // ],
                // [
                //     'name' => 'Bubut',
                //     'description' => 'Bubut',
                //     'departmen_id' => 19,
                // ],
                // // Mekanik
                // [
                //     'name' => 'Mekanik',
                //     'description' => 'Mekanik',
                //     'departmen_id' => 20,
                // ],
                // [
                //     'name' => 'Helper Mekanik',
                //     'description' => 'Helper Mekanik',
                //     'departmen_id' => 20,
                // ],
                // // Electric
                // [
                //     'name' => 'Electric',
                //     'description' => 'Electric',
                //     'departmen_id' => 21,
                // ],
                // // Operator Crane
                // [
                //     'name' => 'Operator Crane',
                //     'description' => 'Operator Crane',
                //     'departmen_id' => 22,
                // ],
                // [
                //     'name' => 'Operator',
                //     'description' => 'Operator',
                //     'departmen_id' => 22,
                // ],
                // // Welder
                // [
                //     'name' => 'Welder',
                //     'description' => 'Welder',
                //     'departmen_id' => 23,
                // ],
                // // Fitter
                // [
                //     'name' => 'Fitter',
                //     'description' => 'Fitter',
                //     'departmen_id' => 24,
                // ],
                // // Helper
                // [
                //     'name' => 'Helper',
                //     'description' => 'Helper',
                //     'departmen_id' => 25,
                // ],
                // // Kebun
                // [
                //     'name' => 'Kebun',
                //     'description' => 'Kebun',
                //     'departmen_id' => 26,
                // ],
                // // Driver
                // [
                //     'name' => 'Driver',
                //     'description' => 'Driver',
                //     'departmen_id' => 27,
                // ],
            ],
        );
    }
}
