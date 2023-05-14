<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert(
            [
                [
                    'name' => 'SITE A',
                    'description' => 'Lokasi SITE A',
                ],
                [
                    'name' => 'SITE B',
                    'description' => 'Lokasi SITE B',
                ],
                [
                    'name' => 'SITE C',
                    'description' => 'Lokasi SITE C',
                ],
            ],
        );
    }
}
