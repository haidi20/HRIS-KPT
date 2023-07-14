<?php

namespace App\Http\Controllers;

use App\Models\AttendanceHasEmployee;
use App\Models\Employee;
use App\Models\JobOrderHasEmployee;
use App\Models\Position;
use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.dashboard.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchTotal()
    {
        $dateNow = Carbon::now()->format("Y-m-d");

        $workingHour = WorkingHour::first();
        $totalEmployee = Employee::active()->count();
        $queryEmployeeNotCombackAfterRest = AttendanceHasEmployee::whereDate("hour_rest_start", $dateNow)
            ->whereNull("hour_rest_end")
            ->distinct("employee_id");
        $queryEmployeeAbsence = AttendanceHasEmployee::whereDate("date", $dateNow)
            ->whereNotNull("employee_id")
            ->whereNotNull("hour_start")
            ->distinct("employee_id");

        $hourMaxLatePresent = Carbon::parse($workingHour->start_time)->addMinutes(90)->format("H:i");
        $queryEmployeeAbsenceLate = clone $queryEmployeeAbsence;
        $queryEmployeeAbsenceLate = $queryEmployeeAbsenceLate->whereTime("hour_start", ">=", $hourMaxLatePresent);

        $dataNotCombackAfterRests = $queryEmployeeNotCombackAfterRest->get();
        $totalNotCombackAfterRest = $queryEmployeeNotCombackAfterRest->count();

        $dataEmployeeIdAbsences = $queryEmployeeAbsence->pluck("employee_id");
        $dataEmployeeAbsences = $queryEmployeeAbsence->get();
        $totalEmployeeAbsence = $queryEmployeeAbsence->count();

        // start not absence
        $queryEmployeeNotAbsence = Employee::active()
            ->select("id", "name", "position_id")
            ->whereNotIn("id", $dataEmployeeIdAbsences);

        $dataEmployeeNotAbsences = $queryEmployeeNotAbsence->get();
        $totalEmployeeNotAbsence = $queryEmployeeNotAbsence->count();
        // end not absence

        // start late present
        $dataEmployeeAbsenceLate = $queryEmployeeAbsenceLate->get();
        $totalEmployeeAbsenceLate = $queryEmployeeAbsenceLate->count();
        // end late present


        return response()->json([
            "success" => true,
            "dateNow" => $dateNow,
            "hourMaxLatePresent" => $hourMaxLatePresent,
            // total
            "totalEmployee" => $totalEmployee,
            "totalEmployeeAbsence" => $totalEmployeeAbsence,
            "totalNotCombackAfterRest" => $totalNotCombackAfterRest,
            "totalEmployeeNotAbsence" => $totalEmployeeNotAbsence,
            "totalEmployeeAbsenceLate" => $totalEmployeeAbsenceLate,
            // data
            "dataEmployeeAbsences" => $dataEmployeeAbsences,
            "dataEmployeeNotAbsences" => $dataEmployeeNotAbsences,
            "dataNotCombackAfterRests" => $dataNotCombackAfterRests,
            "dataEmployeeAbsenceLate" => $dataEmployeeAbsenceLate,
        ]);
    }

    public function fetchTable()
    {
        $dateNowSimulation = Carbon::now()->format("Y-m-11");
        $dateNow = Carbon::now();

        $listNamePositionField = ["Mekanik", "Help Mekanik", "Electric", "Kebun", "Helper", "Rep. Balon"];
        // jabatan pegawai lapangan
        $positionField = Position::whereIn("name", $listNamePositionField)->pluck("id");
        $employeeHaveJobOrder = JobOrderHasEmployee::whereDate("datetime_start", $dateNowSimulation)->pluck("employee_id");
        $employeeNotYetJobOrder = Employee::active()
            ->select("id", "name", "position_id")
            ->whereIn("position_id", $positionField)
            ->whereNotIn("id", $employeeHaveJobOrder)
            ->get();

        $fiveEmployeeHighestJobOrder = JobOrderHasEmployee::whereYear("datetime_start", $dateNow->format("Y"))
            ->whereMonth("datetime_start", $dateNow->format("m"))
            ->select(DB::raw("count(id) as total, employee_id"))
            ->groupBy("employee_id")
            ->orderBy("total", "desc")
            ->limit(5)
            ->get();

        $totalEmployeeBaseOnPosition = [];

        return response()->json([
            "success" => true,
            "employeeNotYetJobOrder" => $employeeNotYetJobOrder,
            "fiveEmployeeHighestJobOrder" => $fiveEmployeeHighestJobOrder,
        ]);
    }
}
