<?php

namespace App\Http\Controllers;

use App\Models\ApprovalLevel;
use App\Models\SalaryAdvance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SalaryAdvanceController extends Controller
{

    /* KASBON
        Salary advance adalah istilah yang digunakan untuk merujuk pada uang yang diberikan kepada karyawan sebelum tanggal gajian mereka,
        yang nantinya akan dikurangi dari gaji mereka pada tanggal gajian selanjutnya.
    */

    private $nameModel = "App\\Models\\SalaryAdvance";

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.salary-advance.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $approvalAgreement = new ApprovalAgreementController;

        $salaryAdvances = SalaryAdvance::orderBy("created_at", "desc")->get();
        $salaryAdvances = $approvalAgreement->mapApprovalAgreeent($salaryAdvances, $this->nameModel, false);

        return response()->json([
            "salaryAdvances" => $salaryAdvances,
            // "user_id" => request("user_id"),
        ]);
    }

    // ketika pengawas input data kasbon
    public function store(Request $request)
    {
        // return request()->all();
        $approvalLevel = ApprovalLevel::where("name", "Kasbon")->first();
        $userId = request("user_id");

        try {
            DB::beginTransaction();

            if (request("id")) {
                $salaryAdvance = SalaryAdvance::find(request("id"));

                $message = "diperbaharui";
            } else {
                $salaryAdvance = new SalaryAdvance;

                $message = "dikirim";
            }

            $salaryAdvance->employee_id = request("employee_id");
            $salaryAdvance->loan_amount = request("loan_amount");
            $salaryAdvance->approval_level_id = $approvalLevel->id;
            $salaryAdvance->reason = request("reason");
            $salaryAdvance->save();

            $this->insertApprovalLevel($salaryAdvance, $userId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => "Gagal {$message}",
            ], 500);
        }
    }

    // proses persetujuan dengan menentukan potongan perbulan
    // role : HRD
    public function storeApprovalSetup()
    {
    }

    // proses persetujuan biasa
    // role : direktur atau kasir
    public function storeApproval()
    {
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $salaryAdvance = SalaryAdvance::find(request("id"));
            $salaryAdvance->update([
                'deleted_by' => request("user_id"),
            ]);
            $salaryAdvance->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }

    private function insertApprovalLevel($faPr, $userId, $statusApproval = null)
    {
        $approvalAgreement = new ApprovalAgreementController;
        $approvalLevel = ApprovalLevel::where("name", "Kasbon")->first();

        $requestApprovalAgreement["approval_level_id"] = $approvalLevel->id; // Purchase Request
        $requestApprovalAgreement["model_id"] =  $faPr->id;
        $requestApprovalAgreement["user_id"] =  $userId;
        $requestApprovalAgreement["name_model"] =  $this->nameModel;

        // accept_onbehalf = perwakilan / atas nama
        if ($statusApproval == "accept_onbehalf") {
            $requestApprovalAgreement["user_behalf_id"] = $userId;
            // $statusApproval = "accept";
        } else {
            $requestApprovalAgreement["user_behalf_id"] = null;
        }

        $requestApprovalAgreement["status_approval"] = $statusApproval != null ? $statusApproval : "review";

        // process insert to approval agreement
        $approvalAgreement->storeApprovalAgreement($requestApprovalAgreement);
    }

    private function fetchDataOld()
    {
        $salaryAdvances = [
            (object)[
                "id" => 1,
                "employee_name" => "Muhammad Adi",
                "amount" => "5.000.000",
                "monthly_deduction" => "1.000.000",
                "duration" => "5 bulan",
                "net_salary" => "4.000.000",
                "date" => "Jum'at, 5 Mei 2023",
            ]
        ];

        return response()->json([
            "salaryAdvances" => $salaryAdvances,
        ]);
    }
}
