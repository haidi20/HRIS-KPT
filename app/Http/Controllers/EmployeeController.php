<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Company;
use App\Models\Departmen;
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
use App\Models\JobOrderHasEmployee;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;


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


    public function index(Datatables $datatables)
    {
        $columns = [
            // 'id' => ['title' => 'No.', 'orderable' => false, 'searchable' => false, 'render' => function () {
            //     return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            // }],
            'id' => ['name' => 'id', 'title' => 'ID Pegawai'],
            'nip' => ['name' => 'nip', 'title' => 'NIP'],
            'name' => ['name' => 'name', 'title' => 'Nama'],
            'position_name' => ['name' => 'position_name', 'title' => 'Nama Jabatan'],
            'location_name' => ['name' => 'location_name', 'title' => 'Nama Lokasi'],
            'company_name' => ['name' => 'company_name', 'title' => 'Nama Perusahaan'],
            'employee_status' => ['name' => 'employee_status', 'title' => 'Status'],
            'aksi' => [
                'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '130px', 'exportable' => false
            ],
        ];

        if ($datatables->getRequest()->ajax()) {
            $employee = Employee::query()
                ->select('employees.*', 'positions.name as position_name', 'locations.name as location_name', 'companies.name as company_name')
                ->with('company', 'location', 'position',) // Eager load the company and position relationships
                ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
                ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
                ->leftJoin('companies', 'employees.company_id', '=', 'companies.id');

            return $datatables->eloquent($employee)
                ->filterColumn('id', function (Builder $query, $keyword) {
                    $sql = "employees.id  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('nip', function (Builder $query, $keyword) {
                    $sql = "employees.nip  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('name', function (Builder $query, $keyword) {
                    $sql = "employees.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('position_name', function (Builder $query, $keyword) {
                    $sql = "positions.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('location_name', function (Builder $query, $keyword) {
                    $sql = "locations.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('company_name', function (Builder $query, $keyword) {
                    $sql = "companies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('employee_status', function (Builder $query, $keyword) {
                    $sql = "employees.employee_status  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('employee_status', function (Employee $data) {
                    if ($data->employee_status == 'aktif') {
                        $employee_status = 'Aktif';
                    } elseif ($data->employee_status == 'meninggal') {
                        $employee_status = 'Meninggal';
                    } else {
                        $employee_status = 'Keluar';
                    }

                    return $employee_status;
                })
                ->addColumn('aksi', function (Employee $data) {
                    $employee = $data->load('company', 'location', 'position'); // Load the related company and position data

                    $button = '';

                    if (auth()->user()->can('ubah karyawan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onEdit(' . htmlspecialchars(json_encode($employee), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-warning me-2"><i class="bi bi-pen"></i></a>';
                    }

                    if (auth()->user()->can('hapus karyawan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onDelete(' . htmlspecialchars(json_encode($employee), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
                    }

                    return $button;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        $columnsArrExPr = [0, 1, 2, 3];
        $html = $datatables->getHtmlBuilder()
            ->columns($columns)
            ->parameters([
                'order' => [[0, 'asc']],
                'responsive' => true,
                'autoWidth' => false,
                'dom' => 'lBfrtip',
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10 Data', '25 Data', '50 Data', 'Semua Data']
                ],
                'buttons' => $this->buttonDatatables($columnsArrExPr),
            ]);

        $employees = Employee::all();
        $companies = Company::all();
        $positions = Position::all();
        $locations = Location::all();
        $employee_types = EmployeeType::all();
        $barges = Barge::all();
        $departments = Departmen::all();
        $finger_tools = FingerTool::all();
        $fingers = Finger::all();

        $compact = compact('html', 'employees', 'companies', 'barges', 'departments', 'positions', 'employee_types', 'locations', 'finger_tools', 'fingers');

        return view("pages.master.employee.index", $compact);
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
                $employee->employee_status = request("employee_status");



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
            $employee->company_id = request("company_id");
            $employee->position_id = request("position_id");
            $employee->location_id = request("location_id");
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
            $employee->out_date = request("out_date");
            $employee->reason = request("reason");

            // DATA GAJI DAN REKENING
            $employee->basic_salary = request("basic_salary");
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

            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }
}
