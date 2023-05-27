<?php

namespace App\Http\Controllers;

use App\Models\salaryAdjustment;
use App\Models\salaryAdjustmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class SalaryAdjustmentController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.setting.salary-adjustment", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $salaryAdjustments = salaryAdjustment::orderBy("created_at", "desc")->get();

        return response()->json([
            "salaryAdjustments" => $salaryAdjustments,
        ]);
    }

    public function store()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $salaryAdjustment = salaryAdjustment::find(request("id"));

                $message = "diperbaharui";
            } else {
                $salaryAdjustment = new salaryAdjustment;

                $message = "dikirim";
            }

            if (request("type_time") == "base time") {
                $salaryAdjustment->date_start = Carbon::parse(request("date_start"))->format("Y-m-d");

                if (request("is_date_end")) {
                    $salaryAdjustment->date_end = Carbon::parse(request("date_end"))->format("Y-m-d");
                }
            }

            $salaryAdjustment->name = request("name");
            $salaryAdjustment->type_time = request("type_time");
            $salaryAdjustment->is_date_end = request("is_date_end", false);
            $salaryAdjustment->type_amount = request("type_amount");
            $salaryAdjustment->amount = request("amount");
            $salaryAdjustment->type_adjustment = request("type_adjustment");
            $salaryAdjustment->note = request("note");
            $salaryAdjustment->save();

            $this->storeSalaryAdjustmentDetail($salaryAdjustment);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => request()->all(),
                'message' => "Berhasil " . $message,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => "Gagal " . $message,
            ], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            // $salaryAdjustment = salaryAdjustment::find(request("id"));
            // $salaryAdjustment->update([
            //     'deleted_by' => request("user_id"),
            // ]);
            // $salaryAdjustment->delete();

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

    public function storeSalaryAdjustmentDetail($salaryAdjustment)
    {
        $employeeSelecteds = request("employee_selecteds");
        $employeeForm = request("employee_form");

        if ($employeeForm["employee_base"] == "choose_employee") {
            foreach ($employeeSelecteds as $index => $item) {
                salaryAdjustmentDetail::updateOrCreate([
                    "employee_id" => $item["id"],
                    "salary_adjustment_id" => $salaryAdjustment->id,
                ], [
                    "type_amount" => $salaryAdjustment->type_amount,
                    "amount" => $salaryAdjustment->amount,
                ]);
            }
        }
    }

    private function fetchDataOld()
    {
        $salaryAdjustments = [
            (object)[
                "id" => 1,
                "name" => "Naik Kapal",
                "time" => "Mei 2023",
                "amount" => "1.000.000",
                "type_adjustment_name" => "penambahan",
                "note" => "bonus turun kapal",
            ],
        ];

        return response()->json([
            "salaryAdjustments" => $salaryAdjustments,
        ]);
    }
}
