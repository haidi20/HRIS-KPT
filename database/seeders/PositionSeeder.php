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
                    'description' => 'Jabatan Pengawas',
                    'departmen_id' => 1,
                ],
                [
                    'name' => 'Ass Mekanik',
                    'description' => 'Jabatan Ass Mekanik',
                    'departmen_id' => 1,
                ],
                [
                    'name' => 'QC',
                    'description' => 'Jabatan QC',
                    'departmen_id' => 1,
                ],
                // HRD
                [
                    'name' => 'HRD',
                    'description' => 'Jabatan HRD',
                    'departmen_id' => 2,
                ],
                // Gudang/ Logistics
                [
                    'name' => 'Logistics',
                    'description' => 'Jabatan Logistics',
                    'departmen_id' => 3,
                ],
                // Mekanik
                [
                    'name' => 'Mekanik',
                    'description' => 'Jabatan Mekanik',
                    'departmen_id' => 4,
                ],
                [
                    'name' => 'Help Mekanik',
                    'description' => 'Jabatan Help Mekanik',
                    'departmen_id' => 4,
                ],
                // Electric
                [
                    'name' => 'Electric',
                    'description' => 'Jabatan Electric',
                    'departmen_id' => 5,
                ],
                // Kebun
                [
                    'name' => 'Kebun',
                    'description' => 'Jabatan Kebun',
                    'departmen_id' => 6,
                ],
                [
                    'name' => 'Helper',
                    'description' => 'Jabatan Helper',
                    'departmen_id' => 6,
                ],
                // Rep. Balon
                [
                    'name' => 'Rep. Balon',
                    'description' => 'Jabatan Rep. Balon',
                    'departmen_id' => 7,
                ],
                // Airbag
                [
                    'name' => 'Airbag',
                    'description' => 'Jabatan Airbag',
                    'departmen_id' => 8,
                ],
                // Driver
                [
                    'name' => 'Driver',
                    'description' => 'Jabatan Driver',
                    'departmen_id' => 9,
                ],
                // Operator
                [
                    'name' => 'Operator',
                    'description' => 'Jabatan Operator',
                    'departmen_id' => 10,
                ],

                // CV KARYA PACIFIC TEKNIK SHIPYARD
                // Manager
                [
                    'name' => 'Manager',
                    'description' => 'Jabatan Manager',
                    'departmen_id' => 11,
                ],
                // Ass Manager
                [
                    'name' => 'Pengawas',
                    'description' => 'Jabatan Pengawas',
                    'departmen_id' => 12,
                ],
                [
                    'name' => 'QC',
                    'description' => 'Jabatan QC',
                    'departmen_id' => 12,
                ],
                // HRD
                [
                    'name' => 'HRD',
                    'description' => 'Jabatan HRD',
                    'departmen_id' => 13,
                ],
                // Pengawas/Supervisor
                [
                    'name' => 'Pengawas/Supervisor',
                    'description' => 'Jabatan Pengawas/Supervisor',
                    'departmen_id' => 14,
                ],
                // Acounting
                [
                    'name' => 'Head of Acounting',
                    'description' => 'Jabatan Head of Acounting',
                    'departmen_id' => 15,
                ],
                [
                    'name' => 'Acounting',
                    'description' => 'Jabatan Acounting',
                    'departmen_id' => 15,
                ],
                [
                    'name' => 'Purchasing',
                    'description' => 'Jabatan Purchasing',
                    'departmen_id' => 15,
                ],
                [
                    'name' => 'Cashier',
                    'description' => 'Jabatan Cashier',
                    'departmen_id' => 15,
                ],
                [
                    'name' => 'Admin',
                    'description' => 'Jabatan Admin',
                    'departmen_id' => 15,
                ],
                [
                    'name' => 'Admin A/R',
                    'description' => 'Jabatan Admin A/R',
                    'departmen_id' => 15,
                ],
                // Marketing
                [
                    'name' => 'Marketing',
                    'description' => 'Jabatan Marketing',
                    'departmen_id' => 16,
                ],
                // Hygiene
                [
                    'name' => 'Office Girl',
                    'description' => 'Jabatan office Girl',
                    'departmen_id' => 17,
                ],
                // Gudang
                [
                    'name' => 'Head of Warehouse',
                    'description' => 'Jabatan Head of Warehouse',
                    'departmen_id' => 18,
                ],
                [
                    'name' => 'Adm. Warehouse',
                    'description' => 'Jabatan Adm. Warehouse',
                    'departmen_id' => 18,
                ],
                // Bubut
                [
                    'name' => 'Kepala Bubut',
                    'description' => 'Jabatan Kepala Bubut',
                    'departmen_id' => 19,
                ],
                [
                    'name' => 'Bubut',
                    'description' => 'Jabatan Bubut',
                    'departmen_id' => 19,
                ],
                // Mekanik
                [
                    'name' => 'Mekanik',
                    'description' => 'Jabatan Mekanik',
                    'departmen_id' => 20,
                ],
                [
                    'name' => 'Helper Mekanik',
                    'description' => 'Jabatan Helper Mekanik',
                    'departmen_id' => 20,
                ],
                // Electric
                [
                    'name' => 'Electric',
                    'description' => 'Jabatan Electric',
                    'departmen_id' => 21,
                ],
                // Operator Crane
                [
                    'name' => 'Operator Crane',
                    'description' => 'Jabatan Operator Crane',
                    'departmen_id' => 22,
                ],
                [
                    'name' => 'Operator',
                    'description' => 'Jabatan Operator',
                    'departmen_id' => 22,
                ],
                // Welder
                [
                    'name' => 'Welder',
                    'description' => 'Jabatan Welder',
                    'departmen_id' => 23,
                ],
                // Fitter
                [
                    'name' => 'Fitter',
                    'description' => 'Jabatan Fitter',
                    'departmen_id' => 24,
                ],
                // Helper
                [
                    'name' => 'Helper',
                    'description' => 'Jabatan Helper',
                    'departmen_id' => 25,
                ],
                // Kebun
                [
                    'name' => 'Kebun',
                    'description' => 'Jabatan Kebun',
                    'departmen_id' => 26,
                ],
                // Driver
                [
                    'name' => 'Driver',
                    'description' => 'Jabatan Driver',
                    'departmen_id' => 27,
                ],
            ],
        );
    }
}
