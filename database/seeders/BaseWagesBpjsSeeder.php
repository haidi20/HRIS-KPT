<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseWagesBpjsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('base_wages_bpjs')->insert(
            [
                [
                    'name' => 'Dasar Upah BPJS TK',
                    'nominal' => '3394513',
                ],
                [
                    'name' => 'Dasar Upah BPJS KES',
                    'nominal' => '3394513',
                ],
            ],
        );
    }
}
