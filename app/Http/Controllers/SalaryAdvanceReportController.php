<?php

namespace App\Http\Controllers;

use App\Models\SalaryAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;

class SalaryAdvanceReportController extends Controller
{
    private $nameModel = "App\\Models\\SalaryAdvance";

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.salary-advance-report.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData($reqStatus = null)
    {
        $dateStart = request("date_start");
        $dateEnd = request("date_end");
        $nameModel = $this->nameModel;
        $userId = (int) request("user_id");

        // is_just_by_status = agar bisa lihat data keseluruhan berdasarkan status accept, reject, atau waiting
        // *note lihat referensi di library.php bagian status

        $isJustByStatus = (bool) request("is_just_by_status", false);
        $isByUser = $isJustByStatus ? false : true;

        $approvalAgreement = new ApprovalAgreementController;
        $salaryAdvances = new SalaryAdvance;

        $salaryAdvances = $approvalAgreement->whereByApproval(
            $salaryAdvances,
            $userId,
            $nameModel,
            $isByUser,
            $dateStart,
            $dateEnd
        );

        $salaryAdvances = $salaryAdvances->orderBy("created_at", "desc")->get();

        $salaryAdvances = $approvalAgreement->mapApprovalAgreement($salaryAdvances, $this->nameModel, $isByUser);


        return response()->json([
            "salaryAdvances" => $salaryAdvances,
            "request" => request()->all(),
        ]);
    }

    // LAPORAN KASBON
    public function indexOld()
    {

        // selanjutnya pindah ke fetchData dapatkan datanya.
        $salaryAdvances = [
            (object)[
                "id" => 1,
                "employee_name" => "Muhammad Adi",
                "amount" => "5.000.000",
                "monthly_deduction" => "1.000.000",
                "duration" => "5 bulan",
                "net_salary" => "4.000.000",
                "remaining_debt" => "1.200.000",
                "date" => "Jum'at, 5 Mei 2023",
                "status" => "accept",
                "reason" => "kebutuhan beli handphone baru",
            ],
        ];

        return view("pages.salary-advance-report.index", compact("salaryAdvances"));
    }
}
