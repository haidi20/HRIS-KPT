<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryAdvanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary_advances')->insert(
            [
                'approval_level_id' => 1,
                'employee_id' => 93,
                'loan_amount' => 2000000,
                'reason' => 'beli HP',
                'created_by' => 1,
            ],
        );
    }
}
