<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Company;
use App\Models\Departmen;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    public function getDepartmens($companyId)
    {
        $departmens = Departmen::with('company')->where('company_id', $companyId)->get();

        return response()->json($departmens);
    }

    public function getPositions($departmenId)
    {
        $positions = Position::with('departmen')->where('departmen_id', $departmenId)->get();

        return response()->json($positions);
    }

    public function index()
    {
        $employees = Employee::all();
        $companies = Company::all();
        $barges = Barge::all();
        $departmens = Departmen::all();
        $positions = Position::all();
        $employee_types = EmployeeType::all();

        return view("pages.master.employee.index", compact("employees", "companies", "barges", "departmens", "positions", "employee_types"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (request("id")) {
                // Logika saat mengubah data
                $employee = Employee::find(request("id"));
                $employee->updated_by = Auth::user()->id;

                // DATA KEPEGAWAIAN
                $employee->enter_date = Carbon::parse($employee->created_at);
                $employee->npwp = request("npwp");
                $employee->no_bpjs = request("no_bpjs");
                $employee->company_id = request("company_id");
                $employee->position_id = request("position_id");
                $employee->employee_type_id = request("employee_type_id");
                $employee->contract_start = request("contract_start");
                $employee->contract_end = request("contract_end");
                $employee->latest_education = request("latest_education");
                $employee->working_hour = request("working_hour");
                $employee->married_status = request("married_status");
                $employee->update(['bpjsTK' => $employee->bpjs_tk]);
                $employee->update(['bpjsTKPT' => $employee->bpjs_tk_pt]);
                $employee->update(['bpjsKES' => $employee->bpjs_kes]);
                $employee->update(['bpjsKESPT' => $employee->bpjs_kes_pt]);
                $employee->update(['bpjsTRAINING' => $employee->bpjs_training]);
                $employee->employee_status = request("employee_status");
                $employee->out_date = request("out_date");
                $employee->reason = request("reason");

                // DATA GAJI DAN REKENING
                $employee->basic_salary = request("basic_salary");
                $employee->rekening_number = request("rekening_number");
                $employee->rekening_name = request("rekening_name");
                $employee->bank_name = request("bank_name");
                $employee->branch = request("branch");

                $message = "diperbaharui";
            } else {
                // Logika saat menambahkan data baru
                $employee = new Employee;
                $employee->created_by = Auth::user()->id;

                $message = "dikirim";
            }

            // DATA PERSONAL
            $employee->nip = request("nip");
            $employee->nik = request("nik");
            $employee->name = request("name");
            $employee->birth_place = request("birth_place");
            $employee->birth_date = request("birth_date");
            $employee->phone = request("phone");
            $employee->religion = request("religion");
            $employee->address = request("address");



            $employee->save();

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

    public function bpjsTK(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_tk = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_tk = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsTKPT(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_tk_pt = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_tk_pt = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsKES(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_kes = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_kes = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsKESPT(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_kes_pt = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_kes_pt = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsTRAINING(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_training = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_training = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }


    public function destroy()
    {
        try {
            DB::beginTransaction();

            $employee = Employee::find(request("id"));
            $employee->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $employee->delete();

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
