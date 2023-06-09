<?php

namespace Database\Seeders;

// use CreateAttendanceHasEmployeesTable;

use App\Models\Attendance;
use App\Models\AttendanceFingerspot;
use App\Models\Employee;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Carbon\CarbonPeriod;


class DummyAbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // ;

        $period = CarbonPeriod::create('2023-05-01', '2023-12-31');

        // Iterate over the period

        foreach (Employee::where('id', 1)->get() as $key => $employe) {
            $employe->roster = 0;
            foreach ($period as $date) {

                $employe->roster += 1;

                $hour_overtime_start = null;
                $hour_overtime_end  = null;
                $duration_overtime = 0;



                if ($employe->working_hour == '6,1') {
                    if ($employe->roster == '7') {
                        $hour_start = null;
                        $hour_end = null;
                        $duration_work = 0;
                        $employe->roster = 0;
                    } else {
                        $hour_start = $date->format('Y-m-d') . " 09:00:00";
                        $hour_end = $date->format('Y-m-d') . " 17:00:00";
                        $duration_work = 7;

                        $duration_overtime = \mt_rand(0, 15);
                        print("==============");
                        print($duration_overtime . "\n");
                        print("==============");

                        $hour_overtime = Carbon::parse($date->format('Y-m-d') . " 17:00:59");

                        if ($duration_overtime > 0) {
                            $hour_overtime_start = $hour_overtime->format('Y-m-d H:i:s');
                            $hour_overtime_end = $hour_overtime->addHours($duration_overtime)->format('Y-m-d H:i:s');
                        }
                    }
                } else {
                    if ($employe->roster == '5') {
                        $hour_start = null;
                        $hour_end = null;
                        $duration_work = 0;
                        $employe->roster = 0;
                    } else {
                        $hour_start = $date->format('Y-m-d') . " 08:00:00";
                        $hour_end = $date->format('Y-m-d') . " 17:00:00";
                        $duration_work = 8;

                        $hour_overtime = Carbon::parse($date->format('Y-m-d') . " 17:00:59");

                        $duration_overtime = \mt_rand(0, 15);
                        print("==============");
                        print($duration_overtime . "\n");
                        print("==============");
                        if ($duration_overtime > 0) {
                            $hour_overtime_start = $hour_overtime->format('Y-m-d H:i:s');
                            $hour_overtime_end = $hour_overtime->addHours($duration_overtime)->format('Y-m-d H:i:s');
                        }
                    }
                }

                Attendance::create([
                    // 'pin'=>1,
                    'employee_id' => $employe->id,
                    'cloud_id' => 12,
                    'date' => $date->format('Y-m-d'),

                    'hour_start' => $hour_start,
                    'hour_end' => $hour_end,
                    'duration_work' => $duration_work,


                    'hour_rest_start' => null,
                    'hour_rest_end' => null,
                    'duration_rest' => null,


                    'hour_overtime_start' => $hour_overtime_start,
                    'hour_overtime_end' => $hour_overtime_end,
                    'duration_overtime' => $duration_overtime,
                ]);
            }
        }

        // CreateAttendanceHasEmployeesTable

    }
}
