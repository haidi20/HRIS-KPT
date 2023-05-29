<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\salaryAdjustment;
use App\Models\salaryAdjustmentDetail;
use App\Models\salaryAdjustmentDetailHistory;
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
        $salaryAdjustments = salaryAdjustment::with("salaryAdjustmentDetails")
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json([
            "salaryAdjustments" => $salaryAdjustments,
        ]);
    }

    public function store()
    {
        // return request()->all();

        $employeeBase = request("employee_base");
        $employeeSelecteds = request("employee_selecteds");

        if (count($employeeSelecteds) == 0 && $employeeBase == "choose_employee") {
            return response()->json([
                'success' => false,
                'message' => "Maaf, minimal 1 karyawan yang dipilih",
            ], 500);
        }

        try {
            DB::beginTransaction();

            if (request("id")) {
                $salaryAdjustment = salaryAdjustment::find(request("id"));

                $message = "diperbaharui";
            } else {
                $salaryAdjustment = new salaryAdjustment;

                $message = "dikirim";
            }

            // ketika ada update data tidak pakai waktu, maka update kosong
            $salaryAdjustment->date_start = null;
            $salaryAdjustment->date_end = null;
            $salaryAdjustment->position_id = null;
            $salaryAdjustment->job_order_id = null;

            if (request("type_time") == "base time") {
                $salaryAdjustment->date_start = Carbon::parse(request("date_start"))->format("Y-m-d");

                if (request("is_date_end")) {
                    $salaryAdjustment->date_end = Carbon::parse(request("date_end"))->format("Y-m-d");
                }
            }

            // start employee form
            if ($employeeBase == "position") {
                $salaryAdjustment->position_id = request("position_id");
            } else if ($employeeBase == "job_order") {
                $salaryAdjustment->job_order_id = request("job_order_id");
            }
            $salaryAdjustment->employee_base = request("employee_base");
            // end employee form

            $salaryAdjustment->name = request("name");
            $salaryAdjustment->type_time = request("type_time");
            $salaryAdjustment->is_date_end = request("is_date_end", false);
            $salaryAdjustment->type_amount = request("type_amount");
            $salaryAdjustment->amount = request("amount");
            $salaryAdjustment->type_adjustment = request("type_adjustment");
            $salaryAdjustment->note = request("note");
            $salaryAdjustment->save();

            $this->storeSalaryAdjustmentDetail($salaryAdjustment, $employeeBase, $employeeSelecteds);

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

    /**
     *Store a salary adjustment detail.
     *@param \App\Models\SalaryAdjustment $salaryAdjustment The salary adjustment model.
     *@param string $employeeBase The employee base.
     *@return void
     */
    public function storeSalaryAdjustmentDetail($salaryAdjustment, $employeeBase, $employeeSelecteds)
    {
        $employees = [];
        $salaryAdjustmentDetail = salaryAdjustmentDetail::where([
            "salary_adjustment_id" => $salaryAdjustment->id,
        ]);
        $salaryAdjustmentDetail->delete();

        if (count($employeeSelecteds) > 0) {
            if ($employeeBase == "choose_employee") {
                foreach ($employeeSelecteds as $index => $item) {
                    $employees[$index] = (object) [
                        "id" => $item["employee_id"],
                    ];
                }
            }
        }

        if ($employeeBase == "all") {
            $employees = Employee::all();
        }

        if ($employeeBase == "position") {
            $employees = Employee::where("position_id", $salaryAdjustment->position_id)->get();
        }

        foreach ($employees as $index => $item) {
            $salaryAdjustmentDetail = salaryAdjustmentDetail::updateOrCreate([
                "employee_id" => $item->id,
                "salary_adjustment_id" => $salaryAdjustment->id,
            ], [
                "type_amount" => $salaryAdjustment->type_amount,
                "amount" => $salaryAdjustment->amount,
            ]);

            $this->storeSalaryAdjustmentDetailHistory($salaryAdjustmentDetail);
        }
    }

    private function storeSalaryAdjustmentDetailHistory($data)
    {
        $salaryAdjustmentDetailHistory = new salaryAdjustmentDetailHistory;
        $salaryAdjustmentDetailHistory->salary_adjustment_id = $data->salary_adjustment_id;
        $salaryAdjustmentDetailHistory->employee_id = $data->employee_id;
        $salaryAdjustmentDetailHistory->type_amount = $data->type_amount;
        $salaryAdjustmentDetailHistory->amount = $data->amount;
        $salaryAdjustmentDetailHistory->created_by = $data->created_by;
        $salaryAdjustmentDetailHistory->updated_by = $data->updated_by;
        $salaryAdjustmentDetailHistory->deleted_by = $data->deleted_by;
        $salaryAdjustmentDetailHistory->created_at = $data->created_at;
        $salaryAdjustmentDetailHistory->updated_at = $data->updated_at;
        $salaryAdjustmentDetailHistory->deleted_at = $data->deleted_at;
        $salaryAdjustmentDetailHistory->save();
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
