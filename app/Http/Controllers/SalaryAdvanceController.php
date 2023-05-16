<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.salary-advance.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
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

    // ketika pengawas input data kasbon
    public function store(Request $request)
    {
        return request()->all();

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
            $salaryAdvance->save();

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
                'deleted_by' => Auth::user()->id,
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
}
