<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\FingerTool;
use App\Models\Location;
use App\Models\Position;
use App\Models\Finger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use PDF;
use App\Exports\LaporanMutasiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Sheets\EmployeePositionSheet;
use App\Exports\Sheets\EmployeeLocationSheet;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;
use App\DataTables\EmployeesDataTable;
use App\DataTables\EmployeesExpDataTable;
use App\Models\Departmen;
use App\Models\salaryAdjustment;
use App\Models\salaryAdjustmentDetail;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;


class EmployeeController extends Controller
{
    private $public_path = '/storage/pegawai/';

    // public function getDepartmens($companyId)
    // {
    //     $departmens = Departmen::with('company')->where('company_id', $companyId)->get();

    //     return response()->json($departmens);
    // }

    // public function getPositions($departmenId)
    // {
    //     $positions = Position::with('departmen')->where('departmen_id', $departmenId)->get();

    //     return response()->json($positions);
    // }

    public function getEmployeeFingers($employeeId)
    {
        $fingers = Finger::with('finger_tool')->where('employee_id', $employeeId)->get();

        return response()->json([
            'success' => true,
            'data' => $fingers
        ]);
    }

    public function deleteEmployeeFingers(Request $request)
    {
        $fingerId = $request->input('fingerId');

        // Temukan data finger berdasarkan ID
        $finger = Finger::find($fingerId);

        if ($finger) {
            // Hapus data finger
            $finger->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data finger berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data finger tidak ditemukan.'
            ]);
        }
    }

    public function index(EmployeesDataTable $dataTable, EmployeesExpDataTable $dataTableExp)
    {
        $employees = Employee::all();
        $companies = Company::all();
        $positions = Position::all();
        $locations = Location::all();
        $employee_types = EmployeeType::all();
        $barges = Barge::all();
        $departments = Departmen::all();
        $finger_tools = FingerTool::all();
        $fingers = Finger::all();

        $dataTableEmployee = $dataTable->html();
        // $dataTableExpEmployee = $dataTableExp->html();

        $compact = compact('dataTableEmployee', 'employees', 'companies', 'barges', 'departments', 'positions', 'employee_types', 'locations', 'finger_tools', 'fingers');

        return $dataTable->render('pages.master.employee.index', $compact);
    }

    private function buttonDatatables($columnsArrExPr)
    {
        return [
            // ['extend' => 'csv', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export CSV'],
            // ['extend' => 'pdf', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export PDF'],
            ['extend' => 'excel', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export Excel'],
            // ['extend' => 'print', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Print'],
        ];
    }


    // untuk kebutuhan di vuejs
    // semua karyawan
    public function fetchData()
    {
        $employees = Employee::active()->orderBy("name", "asc")->get();

        return response()->json([
            "employees" => $employees,
        ]);
    }

    public function fetchOption()
    {
        $employees = Employee::active()
            ->select("id", "position_id", "name",)
            ->orderBy("name", "asc")
            ->get();

        return response()->json([
            "employees" => $employees,
        ]);
    }

    public function fetchForeman()
    {
        $foremans = Employee::active()->whereHas("position", function ($query) {
            $query->where("name", "Pengawas");
        })->get();

        return response()->json([
            "foremans" => $foremans,
        ]);
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

                $message = "ditambahkan";
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

            // $photo = '';
            // if ($request->file('photo')) {
            //     $image = $request->file('photo');
            //     $extension = $image->getClientOriginalExtension();
            //     $fileName = 'photo-' . Str::random(10) . '.' . $extension;
            //     Storage::disk('pegawai')->putFileAs('', $image, $fileName, 'public');
            //     $photo = $fileName;
            // }
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo')->store('employee', 'public');
                $employee->photo = $photo;
            }

            // DATA KEPEGAWAIAN
            $employee->enter_date = Carbon::parse($employee->created_at);
            $employee->npwp = request("npwp");
            $employee->no_bpjs = request("no_bpjs");
            $employee->no_bpjs_tenaga_kerja = request("no_bpjs_tenaga_kerja");
            $employee->company_id = request("company_id");
            $employee->position_id = request("position_id");
            $employee->location_id = request("location_id");
            $employee->employee_type_id = request("employee_type_id");
            $employee->contract_start = request("contract_start");
            $employee->contract_end = request("contract_end");
            $employee->latest_education = request("latest_education");
            $employee->working_hour = request("working_hour");
            $employee->married_status = request("married_status");
            $checkboxFields = ['bpjs_jht', 'bpjs_jkk', 'bpjs_jkm', 'bpjs_jp', 'bpjs_kes'];

            foreach ($checkboxFields as $field) {
                $employee->$field = $request->has($field) ? 'Y' : 'N';
            }

            // $employee->update(['bpjsJHT' => $employee->bpjs_jht]);
            // $employee->update(['bpjsJKK' => $employee->bpjs_jkk]);
            // $employee->update(['bpjsJKM' => $employee->bpjs_jkm]);
            // $employee->update(['bpjsJP' => $employee->bpjs_jp]);
            // $employee->update(['bpjsKES' => $employee->bpjs_kes]);

            $employee->employee_status = request("employee_status");

            $employee->out_date = request("out_date");
            $employee->reason = request("reason");

            // DATA GAJI DAN REKENING
            $basic_salary = str_replace('Rp. ', '', request("basic_salary"));
            $employee->basic_salary = str_replace('.', '', $basic_salary);

            $allowance = str_replace('Rp. ', '', request("allowance"));
            $employee->allowance =  str_replace('.', '', $allowance);

            $meal_allowance_per_attend = str_replace('Rp. ', '', request("meal_allowance_per_attend"));
            $employee->meal_allowance_per_attend = str_replace('.', '', $meal_allowance_per_attend);

            $transport_allowance_per_attend = str_replace('Rp. ', '', request("transport_allowance_per_attend"));
            $employee->transport_allowance_per_attend = str_replace('.', '', $transport_allowance_per_attend);

            $attend_allowance_per_attend = str_replace('Rp. ', '', request("attend_allowance_per_attend"));
            $employee->attend_allowance_per_attend = str_replace('.', '', $attend_allowance_per_attend);

            $overtime_rate_per_hour = str_replace('Rp. ', '', request("overtime_rate_per_hour"));
            $employee->overtime_rate_per_hour = str_replace('.', '', $overtime_rate_per_hour);

            $vat_per_year = str_replace('Rp. ', '', request("vat_per_year"));
            $employee->vat_per_year = str_replace('.', '', $vat_per_year);

            $employee->rekening_number = request("rekening_number");
            $employee->rekening_name = request("rekening_name");
            $employee->bank_name = request("bank_name");
            $employee->branch = request("branch");

            // DATA FINGER
            // $employee->finger_doc_1 = request("finger_doc_1");
            // $employee->finger_doc_2 = request("finger_doc_2");

            $employee->save();

            $finger = Finger::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                    'finger_tool_id' => request('finger_tool_id')
                ],
                [
                    'id_finger' => request('id_finger')
                ]
            );

            // Jika finger sudah ada dan berhasil ditemukan, lakukan update pada id_finger
            if (!$finger->wasRecentlyCreated) {
                $finger->id_finger = request('id_finger');
                $finger->save();
            }

            $salary_adjustment_detail = salaryAdjustmentDetail::firstOrCreate([
                'employee_id' => $employee->id,
            ]);
            $salary_adjustment_detail->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => "Gagal {$message}",
            ], 500);
        }
    }

    public function bpjsJHT(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;

        // If $id is empty, it means this is a new employee, so we need to get the last inserted ID
        if (empty($id)) {
            $lastEmployeeId = DB::table('employees')->orderBy('id')->value('id');
            // Add the last employee ID to the response to update the checkbox's data-employee-id attribute in the frontend
            return response()->json(['lastEmployeeId' => $lastEmployeeId], 200);
        }

        $employee = Employee::find($id);

        // Instead of checking for "true" or "false", directly set the value to "Y" or "N"
        $employee->bpjs_jht = $mode === "Y" ? 'Y' : 'N';
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsJKK(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_jkk = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_jkk = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsJKM(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_jkm = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_jkm = 'N';
            // return 2;
        }
        $employee->update();

        return response()->json($employee, 200);
    }

    public function bpjsJP(Request $request)
    {
        $id = $request->id;
        $mode = $request->mode;
        $employee = Employee::find($id);
        if ($mode == "true") {
            $employee->bpjs_jp = 'Y';
            // return 1;
        } elseif ($mode == "false") {
            $employee->bpjs_jp = 'N';
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

    public function exportExcelPositionEmployee($position_id)
    {
        // Menambahkan filter posisi berdasarkan position_id pada query data karyawan
        $employees = Employee::where('position_id', $position_id)->get();

        $data = ['employees' => $employees, 'position_id' => $position_id];

        return Excel::download(new EmployeePositionSheet($data), 'laporan_pegawai_' . $position_id . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportExcelLocationEmployee($location_id)
    {
        // Menambahkan filter posisi berdasarkan position_id pada query data karyawan
        $employees = Employee::where('location_id', $location_id)->get();

        $data = ['employees' => $employees, 'location_id' => $location_id];

        return Excel::download(new EmployeeLocationSheet($data), 'laporan_pegawai_' . $location_id . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
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

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }
}
