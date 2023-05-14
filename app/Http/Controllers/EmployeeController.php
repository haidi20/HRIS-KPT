<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Company;
use App\Models\Departmen;
use App\Models\Employee;
use App\Models\Position;
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

        return view("pages.master.employee.index", compact("employees", "companies", "barges","departmens", "positions"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (request("id")) {
                // Logika saat mengubah data
                $employee = Employee::find(request("id"));
                $employee->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                // Logika saat menambahkan data baru
                $employee = new Employee;
                $employee->created_by = Auth::user()->id;

                // Set data personal
                $employee->nip = request("nip");
                $employee->nik = request("nik");
                $employee->name = request("name");
                $employee->birth_place = request("birth_place");
                $employee->birth_date = request("birth_date");
                $employee->phone = request("phone");
                $employee->religion = request("religion");
                $employee->address = request("address");

                $message = "dikirim";
            }

            // Simpan data kepegawaian (opsional)
            if (request("company") && request("departmen") && request("position")) {
                $employee->company_id = request("company");
                $employee->departmen_id = request("departmen");
                $employee->position_id = request("position");
            }

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
