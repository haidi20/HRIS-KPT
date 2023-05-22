<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'company_id' => 1,
                'foreman_id' => 1,
                'barge_id' => 1,
                'name' => 'Project 1',
                'date_end' => '2023-06-01',
                'day_duration' => 11,
                'price' => 25000000,
                'down_payment' => 6000000,
                'remaining_payment' => null,
                'type' => 'contract',
                'note' => 'test note',
            ],
            [
                'company_id' => 2,
                'foreman_id' => 2,
                'barge_id' => 2,
                'name' => 'Project 2',
                'date_end' => '2023-06-05',
                'day_duration' => 15,
                'price' => 15000000,
                'down_payment' => 5000000,
                'remaining_payment' => null,
                'type' => 'daily',
                'note' => 'test note',
            ],
        ]);
    }
}
