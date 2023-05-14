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
                ],
                [
                    'name' => 'Kecelakaan (JKK)',
                ],
                [
                    'name' => 'Kematian (JKM)',
                ],
                [
                    'name' => 'Pensiun (JP)',
                ],
                [
                    'name' => 'Kesehatan (BPJS)',
                ],
            ],
        );
    }
}
