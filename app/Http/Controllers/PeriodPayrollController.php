<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PeriodPayroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Spatie\Permission\Models\Permission;

class PeriodPayrollController extends Controller
{
    public function index(Datatables $datatables)
    {
        // return "a";
        $columns = [

            // name
// number_of_workdays




            'id' => ['title' => 'No.', 'orderable' => false, 'searchable' => false, 'render' => function () {
                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            }],
            'name_period' => ['name' => 'name', 'title' => 'Periode'],
            'date_start' => ['name' => 'date_start', 'title' => 'Tanggal Awal Kerja'],
            'date_end' => ['name' => 'date_end', 'title' => 'Tanggal Akhir Kerja'],
            'aksi' => [
                'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '130px', 'exportable' => false
            ],
        ];

        if ($datatables->getRequest()->ajax()) {
            $period_payroll = PeriodPayroll::query()
                ->select('period_payrolls.period','period_payrolls.id', 'period_payrolls.name', 'period_payrolls.date_start', 'period_payrolls.date_end', 'period_payrolls.number_of_workdays');

            return $datatables->eloquent($period_payroll)
                ->filterColumn('name', function (Builder $query, $keyword) {
                    $sql = "period_payrolls.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('name_period', function (PeriodPayroll $data) {
                    return Carbon::parse($data->period)->format('F Y');
                })
                // ->filterColumn('description', function (Builder $query, $keyword) {
                //     $sql = "period_payrolls.description like ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                ->addColumn('aksi', function (PeriodPayroll $data) {
                    $button = '';

                    if (auth()->user()->can('ubah kapal')) {
                        $button .= '<a href="javascript:void(0)" onclick="onEdit(' . htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-warning me-2"><i class="bi bi-pen"></i></a>';
                    }

                    if (auth()->user()->can('hapus kapal')) {
                        $button .= '<a href="javascript:void(0)" onclick="onDelete(' . htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
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
                'order' => [[1, 'desc']],
                'responsive' => true,
                'autoWidth' => false,
                'dom' => 'lfrtip',
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10 Data', '25 Data', '50 Data', 'Semua Data']
                ],
                // 'buttons' => $this->buttonDatatables($columnsArrExPr),
            ]);


        $period_payrolls = PeriodPayroll::all();

        $compact = compact('html', 'period_payrolls');

        return view("pages.period_payroll.index", $compact);
    }

    private function buttonDatatables($columnsArrExPr)
    {
        return [
            ['extend' => 'csv', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export CSV'],
            ['extend' => 'pdf', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export PDF'],
            ['extend' => 'excel', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export Excel'],
            ['extend' => 'print', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Print'],
        ];
    }

    public function fetchData()
    {
        $period_payrolls = PeriodPayroll::orderBy("period", "asc")->get();

        return response()->json([
            "period_payrolls" => $period_payrolls,
        ]);
    }


    public function store(Request $request)
    {
        // return request()->all();

        $n = PeriodPayroll::where('period',request("period")."-01")->count();
        if($n > 0){
            return response()->json([
                'success' => false,
                'message' => "Gagal, Periode Sudah Ada",
            ], 500);
        }

        try {
            DB::beginTransaction();

            if (request("id")) {
                $period_payroll = PeriodPayroll::find(request("id"));
                $period_payroll->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $period_payroll = new PeriodPayroll;
                $period_payroll->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $period_payroll->period = request("period")."-01";
            $period_payroll->date_start = request("date_start");
            $period_payroll->date_end = request("date_end");
            $period_payroll->save();


            $employees = Employee::all();

            foreach ($employees as $key => $employee) {

                $jumlah_hari_kerja  = Attendance::whereDate('date','>=',$period_payroll->date_start)
                ->whereDate('date','<=',$period_payroll->date_end)
                ->where('employee_id',$employee->id)
                ->where(function($query){
                    $query->where('hour_start','!=',NULL)->orWhere('hour_end','!=',NULL);
                })
                ->count();

                $jumlah_jam_rate_lembur  = Attendance::whereDate('date','>=',$period_payroll->date_start)
                ->whereDate('date','<=',$period_payroll->date_end)
                ->where('employee_id',$employee->id)
                ->where(function($query){
                    $query->where('hour_start','!=',NULL)->orWhere('hour_end','!=',NULL);
                })
                ->sum('duration_overtime');

                $jumlah_jam_rate_lembur_modulus  = $jumlah_jam_rate_lembur %60;

                if($jumlah_jam_rate_lembur >= 30 && $jumlah_jam_rate_lembur <= 50){
                    $jumlah_jam_rate_lembur+= 0.5;
                }

                if($jumlah_jam_rate_lembur > 50){
                    $jumlah_jam_rate_lembur+= 1;
                }




                Payroll::create([
                    'employee_id'=>$employee->id,
                    'period_payroll_id'=>$period_payroll->id,
                    'pendapatan_gaji_dasar'=>$employee->basic_salary,
                    'pendapatan_tunjangan_tetap'=>$employee->allowance,
                    'pendapatan_uang_makan'=>$employee->meal_allowance_per_attend,
                    'pendapatan_lembur'=>$employee->overtime_rate_per_hour,
                    'pendapatan_tambahan_lain_lain'=>0,
                    'jumlah_pendapatan'=>0,


                    'pemotongan_bpjs_dibayar_karyawan'=>0,
                    'pemotongan_pph_dua_satu'=>0,
                    'pemotongan_potongan_lain_lain'=>0,
                    'jumlah_pemotongan'=>0,

                    'gaji_bersih'=>0,
                    'bulan'=>$period_payroll->period,
                    'posisi'=>"",
                    'gaji_dasar'=>$employee->basic_salary,
                    'tunjangan_tetap'=>$employee->allowance,


                    'rate_lembur'=>$employee->overtime_rate_per_hour,
                    'jumlah_jam_rate_lembur'=>$jumlah_jam_rate_lembur,




                    'tunjangan_makan'=>$employee->meal_allowance_per_attend,
                    'jumlah_hari_tunjangan_makan'=>$jumlah_hari_kerja,



                    'tunjangan_transport'=>$employee->transport_allowance_per_attend,
                    'jumlah_hari_tunjangan_transport'=>$jumlah_hari_kerja,



                    'tunjangan_kehadiran'=>$employee->attend_allowance_per_attend,
                    'jumlah_hari_tunjangan_kehadiran'=>$jumlah_hari_kerja,


                    'ptkp_karyawan'=>0,
                    'jumlah_cuti_ijin_per_bulan'=>0,
                    'sisa_cuti_tahun'=>0,

                    'dasar_updah_bpjs_tk'=>0,
                    'dasar_updah_bpjs_kes'=>0,



                    'jht_perusahaan_persen'=>0,
                    'jht_karyawan_persen'=>0,
                    'jht_perusahaan_rupiah'=>0,
                    'jht_karyawan_rupiah'=>0,

                    'jkk_perusahaan_persen'=>0,
                    'jkk_karyawan_persen'=>0,
                    'jkk_perusahaan_rupiah'=>0,
                    'jkk_karyawan_rupiah'=>0,

                    'jkm_perusahaan_persen'=>0,
                    'jkm_karyawan_persen'=>0,
                    'jkm_perusahaan_rupiah'=>0,
                    'jkm_karyawan_rupiah'=>0,

                    'jp_perusahaan_persen'=>0,
                    'jp_karyawan_persen'=>0,
                    'jp_perusahaan_rupiah'=>0,
                    'jp_karyawan_rupiah'=>0,

                    'bpjs_perusahaan_persen'=>0,
                    'bpjs_karyawan_persen'=>0,
                    'bpjs_perusahaan_rupiah'=>0,
                    'bpjs_karyawan_rupiah'=>0,
                ]);
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
                'message' => "Gagal {$message} {$e->getMessage()}",
            ], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $period_payroll = PeriodPayroll::find(request("id"));
            $period_payroll->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $period_payroll->delete();

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
