<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FeatureSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RosterStatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DepartmenSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(WorkingHourSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(BargeSeeder::class);
        $this->call(FingerToolSeeder::class);
        $this->call(BpjsCalculationSeeder::class);
        $this->call(EmployeeTypeSeeder::class);
        $this->call(ApprovalSeeder::class);
        $this->call(BaseWagesBpjsSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ContractorSeeder::class);
        $this->call(OrdinarySeamanSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
