<?php

namespace Database\Seeders;

use App\Models\User;
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
                [
                    'name' => 'Welder',
                    'minimum_employee' => 2,
                ],
                [
                    'name' => 'Operator',
                    'minimum_employee' => 3,
                ],
            ],
        );
    }
}
