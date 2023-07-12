<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Roster;
use Illuminate\Database\Seeder;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
// php artisan db:seed --class=DummyPayrollSeeder
class DummyPayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::with('position')->get();


        Position::whereIn('name',[
            'Head of Acounting',
            'Acounting',
            'Purchasing',
            'Cashier',
            'Admin',
            'Admin A/R',
            'Marketing',
            'office Girl',
            'Head of Warehouse',
            'Adm. Warehouse'
        ])->update(['is_office'=>1]);

        $iter = 0;

        foreach ($employees as $key => $e) {

            if (isset($e->position->is_office) && ($e->position->is_office == 1)){
                $e->working_hour = '5,2';
                $e->save();
            }else{

                // $iter = 1;
                $e->working_hour = '5,2';
                if($iter%2==0){
                    $e->working_hour = '6,1';
                }

                $e->save();
            }

            $period = CarbonPeriod::create('2021-12-26', '2022-12-25');
            
            foreach ($period as $key => $p) {
                print("GENERATE EMLOYEE_ID : ".$e->id." ||  PERIOD : ".$p->format('d F Y')."\n");

                $name_day = strtolower($p->format('l'));

                if($name_day == 'saturday' and $e->working_hour  == '5,2'){
                    $status_roster = 'OFF';
                }

                if($name_day == 'sunday' and $e->working_hour  == '5,2'){
                    $status_roster = 'OFF';
                }

                if($name_day == 'sunday' and $e->working_hour  == '6,2'){
                    $status_roster = 'OFF';
                }

                // print($name_day."\n");
                // Roster::create([
                //     'employee_id'=>$e->id,
                //     'position_id'=>$e->position->id ?? null,
                //     'month'=>$p->startOfMonth(),
                //     'roster_status_id'=>
                // ]);
                # code...
            }






            # code...

            $iter++;
        }
    }
}
