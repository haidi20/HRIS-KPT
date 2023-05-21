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
                'name' => 'Project 1',
                'date_end' => '2023-06-01',
                'day_duration' => null,
                'price' => 25000000,
                'price_readable' => null,
                'down_payment' => 6000000,
                'down_payment_readable' => null,
                'remaining_payment' => null,
                'remaining_payment_readable' => null,
                'type' => 'contract',
            ],
            [
                'company_id' => 2,
                'foreman_id' => 2,
                'name' => 'Project 2',
                'date_end' => '2023-06-05',
                'day_duration' => null,
                'price' => 15000000,
                'price_readable' => null,
                'down_payment' => 5000000,
                'down_payment_readable' => null,
                'remaining_payment' => null,
                'remaining_payment_readable' => null,
                'type' => 'daily',
            ],
        ]);
    }
}
