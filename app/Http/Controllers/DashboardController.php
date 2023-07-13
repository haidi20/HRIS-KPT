<?php

namespace App\Http\Controllers;

use App\Models\AttendanceHasEmployee;
use App\Models\Employee;
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
        $dateNow = Carbon::now()->format("Y-m-11");

        $totalEmployee = Employee::active()->count();
        $queryEmployeeNotCombackAfterRest = AttendanceHasEmployee::whereDate("hour_rest_start", $dateNow)
            ->whereNull("hour_rest_end")
            ->distinct("employee_id");
        $queryEmployeeAbsence = AttendanceHasEmployee::whereDate("date", $dateNow)
            ->whereNotNull("employee_id")
            ->whereNotNull("hour_start")
            ->distinct("employee_id");

        $dataNotCombackAfterRests = $queryEmployeeNotCombackAfterRest->get();
        $totalNotCombackAfterRest = $queryEmployeeNotCombackAfterRest->count();

        $dataEmployeeAbsences = $queryEmployeeAbsence
            ->pluck("employee_id");
        $totalEmployeeAbsence = $queryEmployeeAbsence->count();

        $queryEmployeeNotAbsence = Employee::active()
            ->select("id", "name", "position_id")
            ->whereNotIn("id", $dataEmployeeAbsences);

        $dataEmployeeNotAbsences = $queryEmployeeNotAbsence->get();
        $totalEmployeeNotAbsence = $queryEmployeeNotAbsence->count();

        return response()->json([
            "success" => true,
            "dateNow" => $dateNow,
            // total
            "totalEmployee" => $totalEmployee,
            "totalEmployeeAbsence" => $totalEmployeeAbsence,
            "totalNotCombackAfterRest" => $totalNotCombackAfterRest,
            "totalEmployeeNotAbsence" => $totalEmployeeNotAbsence,
            // data
            "dataEmployeeAbsences" => $dataEmployeeAbsences,
            "dataEmployeeNotAbsences" => $dataEmployeeNotAbsences,
            "dataNotCombackAfterRests" => $dataNotCombackAfterRests,
        ]);
    }

    // whereYear("hour_rest_start", $dateNow->format("Y"))
    //         ->whereMonth("hour_rest_start", $dateNow->format("m"))
}
