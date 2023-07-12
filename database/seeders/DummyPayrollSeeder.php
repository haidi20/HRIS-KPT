<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Roster;
use App\Models\RosterDaily;
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

        RosterDaily::truncate();
        Attendance::truncate();





        $karyawan_tipe_1 = 0;
        $karyawan_tipe_2 = 0;
        $karyawan_tipe_3 = 0;
        $tipe_karyawan  = '';


        Position::whereIn('name', [
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
        ])->update(['is_office' => 1]);

        $iter = 0;

        foreach ($employees as $key => $e) {

            if (isset($e->position->is_office) && ($e->position->is_office == 1)) {
                $e->working_hour = '5,2';
                $e->save();
                $karyawan_tipe_1++;
                $tipe_karyawan = "1";
            } else {

                // $iter = 1;

                if ($iter % 2 == 0) {
                    $e->working_hour = '6,1';
                    $karyawan_tipe_2++;
                    $tipe_karyawan = "2";
                } else {
                    $e->working_hour = '5,2';
                    $karyawan_tipe_3++;
                    $tipe_karyawan = "3";
                }

                $e->save();
            }

            if ($tipe_karyawan == 1 && $karyawan_tipe_1 > 4) {
                continue;
            }

            if ($tipe_karyawan == 2 && $karyawan_tipe_2 > 4) {
                continue;
            }

            if ($tipe_karyawan == 3 && $karyawan_tipe_3 > 4) {
                continue;
            }

            // if($karyawan_tipe_1 >  3 || $karyawan_tipe_2 >  3 || $karyawan_tipe_3 >  3 ){
            //     print("karyawan_tipe_1 -> ".$karyawan_tipe_1." | karyawan_2 -> ".$karyawan_tipe_2." | karyawan_3 -> ".$karyawan_tipe_3."\n");
            //     continue;
            // }

            $period = CarbonPeriod::create('2021-12-26', '2022-12-25');
            // print("GENERATE EMLOYEE_ID : ".$e->id." | Tipe Karyawan : ".$tipe_karyawan."\n");

            foreach ($period as $key => $p) {
                

                $name_day = strtolower($p->format('l'));

                if ($name_day == 'saturday' and $e->working_hour  == '5,2') {
                    $status_roster = 'OFF';
                    $status_roster_id = 5;
                    // print("\t\t---------------------\n");
                } elseif ($name_day == 'sunday' and $e->working_hour  == '5,2') {
                    $status_roster = 'OFF';
                    $status_roster_id = 5;
                    // print("\t\t---------------------\n");
                } elseif ($name_day == 'sunday' and $e->working_hour  == '6,1') {
                    $status_roster = 'OFF';
                    $status_roster_id = 5;
                    // print("\t\t---------------------\n");
                } else {
                    $status_roster = 'M';
                    $status_roster_id = 3;
                }


                print("GENERATE EMLOYEE_ID : " . $e->id . " ||  PERIOD : " . $p->format('d F Y') ." | ROSTER : ".$status_roster." | WORKING ->".$e->working_hour. "\n");

                

                // print($name_day."\n");
                $roster = RosterDaily::firstOrcreate([
                    'date' => $p,
                    'employee_id' => $e->id,
                    'position_id' => $e->position->id ?? null,
                    // 'month'=>$p->startOfMonth(),
                    'roster_status_id' => $status_roster_id
                ]);



                $hour_overtime_start = null;
                $hour_overtime_end = null;
                $duration_overtime = null;

                if ($e->working_hour == '6,1') {
                    if ($status_roster_id == '5') {
                        $hour_start = null;
                        $hour_end = null;
                        $duration_work = 0;
                        // $status_roster_id = 0;
                    } else {
                        $hour_start = $p->format('Y-m-d') . " 09:00:00";
                        $hour_end = $p->format('Y-m-d') . " 17:00:00";
                        $duration_work = 7*60;

                        $duration_overtime = \mt_rand(0, 15)*60;
                        // print("==============");
                        // print($duration_overtime . "\n");
                        // print("==============");

                        $hour_overtime = Carbon::parse($p->format('Y-m-d') . " 17:00:59");

                        if ($duration_overtime > 0) {
                            $hour_overtime_start = $hour_overtime->format('Y-m-d H:i:s');
                            $hour_overtime_end = $hour_overtime->addHours($duration_overtime)->format('Y-m-d H:i:s');
                        }
                    }
                } else {
                    if ($status_roster_id == '5') {
                        $hour_start = null;
                        $hour_end = null;
                        $duration_work = 0;
                        // $status_roster_id = 0;
                    } else {
                        $hour_start = $p->format('Y-m-d') . " 08:00:00";
                        $hour_end = $p->format('Y-m-d') . " 17:00:00";
                        $duration_work = 8*60;

                        $hour_overtime = Carbon::parse($p->format('Y-m-d') . " 17:00:59");

                        $duration_overtime = \mt_rand(0, 24) * 60;
                        // print("==============");
                        // print($duration_overtime . "\n");
                        // print("==============");
                        if ($duration_overtime > 0) {
                            $hour_overtime_start = $hour_overtime->format('Y-m-d H:i:s');
                            $hour_overtime_end = $hour_overtime->addHours($duration_overtime)->format('Y-m-d H:i:s');
                        }
                    }
                }




                $attendance  = Attendance::firstOrCreate([
                    'employee_id' => $e->id,
                    'cloud_id' => 12,
                    'date' => $p->format('Y-m-d'),
                ]);

                $attendance->update([
                    'roster_daily_id'=>$status_roster_id,
                    'roster_status_initial'=>$status_roster,
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



                // Attendance::create([

                // ]);
                # code...
            }






            # code...

            if ($karyawan_tipe_1 >  3 && $karyawan_tipe_2 >  3 && $karyawan_tipe_3 >  3) {
                break;
            }

            $iter++;
        }
    }
}
