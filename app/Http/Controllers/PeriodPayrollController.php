<?php

namespace App\Http\Controllers;

// use ___PHPSTORM_HELPERS\object;
use App\Exports\PayrollExport;
use App\Models\Attendance;
use App\Models\AttendanceHasEmployee;
use App\Models\AttendancePayrol;
use App\Models\BaseWagesBpjs;
use App\Models\BpjsCalculation;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PeriodPayroll;
use App\Models\RosterDaily;
use App\Models\salaryAdjustmentDetail;
use App\Models\SalaryAdvanceDetail;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Carbon\CarbonPeriod;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PeriodPayrollController extends Controller
{
    public $period_payrol_month_year;
    public function __construct($period_payrol_month_year = [])
    {
        $this->period_payrol_month_year = $period_payrol_month_year;
        // print("\nFUNGSI IN \n");
        // if (count($period_payrol_month_year) == 0) {
        //     $this->period_payrol_month_year = $period_payrol_month_year;
        // } else {
        //     $this->period_payrol_month_year = (object) $period_payrol_month_year;
        // }
    }
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
            // 'date_start' => ['name' => 'date_start', 'title' => 'Tanggal Awal Kerja'],
            // 'date_end' => ['name' => 'date_end', 'title' => 'Tanggal Akhir Kerja'],
            'slip_gaji' => [
                'title' => "Slip Gaji", 'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '50%', 'exportable' => false
            ],
            'rekap_gaji' => [
                'title' => "Rekap Gaji", 'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '50%', 'exportable' => false
            ],
        ];

        if ($datatables->getRequest()->ajax()) {
            $period_payroll = PeriodPayroll::query()
                ->select('period_payrolls.last_excel', 'period_payrolls.period', 'period_payrolls.id', 'period_payrolls.name', 'period_payrolls.date_start', 'period_payrolls.date_end', 'period_payrolls.number_of_workdays');

            return $datatables->eloquent($period_payroll)
                ->filterColumn('name', function (Builder $query, $keyword) {
                    $sql = "period_payrolls.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->removeColumn(['last_excel', 'period', 'name', 'number_of_workdays'])
                ->addColumn('name_period', function (PeriodPayroll $data) {
                    return Carbon::parse($data->period)->format('F Y');
                })
                // ->filterColumn('description', function (Builder $query, $keyword) {
                //     $sql = "period_payrolls.description like ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                ->addColumn('slip_gaji', function (PeriodPayroll $data) {
                    $button = '<div><div class="btn-group">';

                    if (auth()->user()->can('download payroll')) {
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"> PT & CV KPT</i></a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"></i> CV KPT</a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"></i> PT KPT</a>';
                        // $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-download"></i></a>';
                    }

                    $button .= '</div> <br><br>';

                    $button .= '<div class="btn-group">';

                    if (auth()->user()->can('download payroll')) {
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"> PT & CV KPT</i></a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"></i> CV KPT</a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"></i> PT KPT</a>';
                        // $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-warning me-2"><i class="bi bi-download"></i></a>';
                    }

                    $button .= '</div><div>';



                    return $button;
                })

                ->addColumn('rekap_gaji', function (PeriodPayroll $data) {
                    $button = '<div><div class="btn-group">';

                    if (auth()->user()->can('download payroll')) {
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"> PT & CV KPT</i></a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"></i> CV KPT</a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-success me-2"><i class="bi bi-filetype-csv"></i> PT KPT</a>';
                        // $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-warning me-2"><i class="bi bi-download"></i></a>';
                    }

                    $button .= '</div> <br><br>';

                    $button .= '<div class="btn-group">';

                    if (auth()->user()->can('download payroll')) {
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"> PT & CV KPT</i></a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"></i> CV KPT</a>';
                        $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-filetype-pdf"></i> PT KPT</a>';
                        // $button .= '<a href="javascript:void(0)" data-download="' . url()->current() . "/export?a=" . $data->last_excel . '" class="btn-download btn btn-sm btn-danger me-2"><i class="bi bi-download"></i></a>';
                    }

                    $button .= '</div><div>';



                    return $button;
                })
                ->rawColumns(['rekap_gaji', 'slip_gaji'])
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


    public function store()
    {

        try {
            DB::beginTransaction();

            if ($this->period_payrol_month_year != null) {
                // print("\n\n xxxxxxxxxxxxxxxxxxxxxxx\n");

                $n = PeriodPayroll::where('period', $this->period_payrol_month_year->periode . "-01")->count();

                if ($n > 0) {
                    $period_payroll = PeriodPayroll::where('period', $this->period_payrol_month_year->periode . "-01")->first();
                    $message = "diperbaharui";
                } else {
                    if (request("id")) {
                        $period_payroll = PeriodPayroll::find(request("id"));
                        $period_payroll->updated_by = Auth::user()->id ?? null;

                        $message = "diperbaharui";
                    } else {
                        $period_payroll = new PeriodPayroll;
                        $period_payroll->created_by = Auth::user()->id ?? null;

                        $message = "ditambahkan";
                    }
                }


                // print_r($this->period_payrol_month_year);
                $period_payroll->period = $this->period_payrol_month_year->periode . "-01";
                $period_payroll->date_start = $this->period_payrol_month_year->date_start;
                $period_payroll->date_end = $this->period_payrol_month_year->date_end;
            } else {
                // $n = PeriodPayroll::where('period', request("period") . "-01")->count();

                // if ($n > 0) {
                //     $period_payroll = PeriodPayroll::where('period', request("period") . "-01")->first();
                //     $message = "diperbaharui";
                // } else {
                //     if (request("id")) {
                //         $period_payroll = PeriodPayroll::find(request("id"));
                //         $period_payroll->updated_by = Auth::user()->id ?? null;

                //         $message = "diperbaharui";
                //     } else {
                //         $period_payroll = new PeriodPayroll;
                //         $period_payroll->created_by = Auth::user()->id ?? null;

                //         $message = "ditambahkan";
                //     }
                // }




                // $period_payroll->period = request("period") . "-01";
                // $period_payroll->date_start = request("date_start");
                // $period_payroll->date_end = request("date_end");
            }

            if ($period_payroll->is_final == 1) {
                if ($this->period_payrol_month_year != null) {
                    Log::error('sudah ada');
                    print("Sudah Ada");
                    return false;
                } else {
                    Log::error('sudah ada');
                    print("Sudah Ada");
                    return false;
                }
            }
            $period_payroll->save();


            // AttendancePayrol::whereDate('date','>=',$period_payroll->date_start)
            // ->whereDate('date','<=',$period_payroll->date_end)
            // ->get();
            // AttendancePayrol::create();

            // if ($message == 'ditambahkan') {
            //     DB::select("
            //     INSERT INTO attendance(pin, cloud_id,employee_id,date,hour_start,hour_end,duration_work,hour_rest_start,hour_rest_end,duration_rest,hour_overtime_start,hour_overtime_end,duration_overtime,hour_overtime_job_order_start,hour_overtime_job_order_end,duration_overtime_job_order,is_weekend,is_vacation,is_payroll_use,payroll_id)
            //     SELECT pin, cloud_id,employee_id,date,hour_start,hour_end,duration_work,hour_rest_start,hour_rest_end,duration_rest,hour_overtime_start,hour_overtime_end,duration_overtime,hour_overtime_job_order_start,hour_overtime_job_order_end,duration_overtime_job_order,is_weekend,is_vacation,is_payroll_use,payroll_id
            //     FROM attendance_has_employees where date(date) >= '" . $period_payroll->date_start . "' AND date(date) <= '" . $period_payroll->date_end . "'
            //     ");
            // }











            $employees = Employee::where('id', 1)->orderBy('name', 'asc')->get();

            $bpjs_jht = BpjsCalculation::where('code', 'jht')->first();
            $bpjs_jkk = BpjsCalculation::where('code', 'jkk')->first();
            $bpjs_jkm = BpjsCalculation::where('code', 'jkm')->first();
            $bpjs_jp = BpjsCalculation::where('code', 'jp')->first();
            $bpjs_kes = BpjsCalculation::where('code', 'kes')->first();




            $bpjs_dasar_updah_bpjs_tk = BaseWagesBpjs::where('code', 'jk')->first()->nominal ?? 0;
            $dasar_updah_bpjs_kes = BaseWagesBpjs::where('code', 'kes')->first()->nominal ?? 0;

            // print("\n\n\n FFFFFFFFFFFFFFFFFFFFF \n");


            $tanggal_tambahan_lain =  Carbon::parse($period_payroll->period . "-30");

            // print_r([$period_payroll->date_start,$period_payroll->date_end]);

            $period = CarbonPeriod::create($period_payroll->date_start, $period_payroll->date_end);

            // print("masuk sini -----------------");
            foreach ($employees as $key => $employee) {
                $employee_id = $employee->id;
                $start_date = $period_payroll->date_start;
                $end_date =  $period_payroll->date_end;
                // AttendanceHasEmployee
                $attende_fingers = AttendanceHasEmployee::where('employee_id', $employee_id)
                    ->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

                // return $sql = Str::replaceArray('?', $attende_fingers->getBindings(), $attende_fingers->toSql());

                foreach ($attende_fingers as $key => $v) {
                    $new_at  = Attendance::firstOrCreate([
                        'employee_id' => $employee_id,
                        'date' => $v->date,
                    ]);

                    if ($new_at->is_koreksi == 0) {
                        $new_at->update([
                            'hour_start' => $v->hour_start,
                            'hour_end' => $v->hour_end,
                            'duration_work' => $v->duration_work,

                            'hour_rest_start' => $v->hour_rest_start,
                            'hour_rest_end' => $v->hour_rest_end,
                            'duration_rest' => $v->duration_rest,

                            'hour_overtime_start' => $v->hour_overtime_start,
                            'hour_overtime_end' => $v->hour_overtime_end,
                            'duration_overtime' => $v->duration_overtime,
                        ]);
                    }


                    //validasi lembur
                }



                $data_absens = Attendance::where('employee_id', $employee->id)
                    ->whereDate('date', '>=', $period_payroll->date_start)
                    ->whereDate('date', '<=', $period_payroll->date_end)
                    ->get();

                // print("-----------");
                // print_r(json_encode($data_absens->pluck('date')));
                // print("-----------");

                $jumlah_jam_lembur_tmp = 0;
                $jumlah_hari_kerja_tmp = 0;
                $jumlah_hari_tidak_masuk_tmp = 0;


                $jumlah_hutang  = 0;

                // print("MASUK PERIODCONTROLER -----xxxxx");

                // return [$period_payroll->date_start, $period_payroll->date_end];

                $jumlah_hutang =  SalaryAdvanceDetail::whereDate('date_start', '<=', $period_payroll->date_end)
                    ->whereDate('date_end', '>=', $period_payroll->date_end)
                    ->sum('amount');

                foreach ($period as $key => $p) {
                    $new_old_d = $data_absens->where('date', $p->format('Y-m-d'))->first();
                    if ($new_old_d != null) {
                        // print_r(json_encode($data_absens->pluck('date')));
                    }


                    $roster_daily = RosterDaily::where('employee_id', $employee->id)
                        ->whereDate('date', $p->format('Y-m-d'))
                        ->first();
                    //  if( $p->format('Y-m-d')=='2023-06-19'){
                    //     return $new_old_d;
                    //  }
                    $kali_1 = 0.00;
                    $kali_2 = 0.00;
                    $kali_3 = 0.00;
                    $kali_4 = 0.00;

                    if (isset($new_old_d->id)) {

                        $old_sekali_at = Attendance::findOrFail($new_old_d->id);
                        // print("\t\tOVERTIME : ".$old_sekali_at->duration_overtime)."\n";
                        $jumlah_hari_kerja_tmp += 1;
                        if (($old_sekali_at->duration_overtime != null) && ($old_sekali_at->duration_overtime > 0)) {

                            if ($$old_sekali_at->is_koreksi_lembur == 0) {
                                $hour_lembur_x = $old_sekali_at->duration_overtime % 60;
                                $hour_lembur_y =  \floor($old_sekali_at->duration_overtime / 60);



                                for ($i = 1; $i <= $hour_lembur_y; $i++) {
                                    if ($i == 1) {
                                        $jumlah_jam_lembur_tmp += 1.5;
                                        $kali_1 += 1.5;
                                    } elseif ($i > 1 && $i < 8) {
                                        $jumlah_jam_lembur_tmp += 2.00;
                                        $kali_2 += 2.00;
                                    } elseif ($i == 8) {
                                        $jumlah_jam_lembur_tmp += 3.00;
                                        $kali_3 += 3.00;
                                    } elseif ($i > 8) {
                                        $jumlah_jam_lembur_tmp += 4.00;
                                        $kali_4 += 4.00;
                                    }
                                }

                                if (($hour_lembur_x > 29) && ($hour_lembur_x < 45) && ($jumlah_jam_lembur_tmp == 0)) {
                                    $jumlah_jam_lembur_tmp += 1.5 * 0.5;
                                    $kali_1 += 1.5 * 0.5;
                                }

                                if (($hour_lembur_x >= 45) && ($jumlah_jam_lembur_tmp == 0)) {
                                    $jumlah_jam_lembur_tmp += 1.5;
                                    $kali_1 += 1.5;
                                }


                                if (($hour_lembur_x > 29) && ($hour_lembur_x < 45) && ($jumlah_jam_lembur_tmp > 0)) {
                                    $jumlah_jam_lembur_tmp += 2 * 0.5;
                                    $kali_2 += 2 * 0.5;
                                }

                                if (($hour_lembur_x >= 45) && ($jumlah_jam_lembur_tmp > 0)) {
                                    $jumlah_jam_lembur_tmp += 2.00;
                                    $kali_2 += 2.00;
                                }

                                Attendance::where('id', $new_old_d->id)->update([
                                    'lembur_kali_satu_lima' => $kali_1,
                                    'lembur_kali_dua' => $kali_2,
                                    'lembur_kali_tiga' => $kali_3,
                                    'lembur_kali_empat' => $kali_4,
                                    'roster_daily_id' => $roster_daily->id ?? null,
                                    'roster_status_initial' => $roster_daily->roster_status_initial ?? null
                                ]);
                            }else{
                                $jumlah_jam_lembur_tmp = $new_old_d->id->lembur_kali_satu_lima + $new_old_d->id->lembur_kali_dua + $new_old_d->id->lembur_kali_tiga + $new_old_d->id->lembur_kali_empat ; 
                            }

                            
                        }

                        // print_r([
                        //     'lembur_kali_satu_lima' => $kali_1,
                        //     'lembur_kali_dua' => $kali_2,
                        //     'lembur_kali_tiga' => $kali_3,
                        //     'lembur_kali_empat' => $kali_4,
                        //     'roster_daily_id' => $roster_daily->id ?? null,
                        //     'roster_status_initial' => $roster_daily->roster_status_initial ?? null
                        // ]);
                    } else {

                        $is_weekend = 0;
                        $is_vacation = 0;
                        $is_absen = 0;

                        if (isset($roster_daily->id)) {
                            if ($roster_daily->roster_status_initial == 'M') {


                                $vacations = Vacation::where('employee_id', $employee->id)
                                    ->whereYear('date_start', Carbon::now()->format('Y'))
                                    ->where('status', 'accept')
                                    ->select(
                                        DB::raw('DATEDIFF(date_start, date_end) AS jumlah_hari_cuti')
                                    )
                                    ->get();

                                $jumlah_hari_cuti = 0;

                                foreach ($vacations as $key => $v) {
                                    $jumlah_hari_cuti += $v->jumlah_hari_cuti;
                                }

                                if (($jumlah_hari_cuti + 1) > $employee->day_vacation) {
                                    $jumlah_hari_tidak_masuk_tmp += 1;
                                    $is_absen = 1;
                                } else {
                                    Vacation::create([
                                        'employee_id' => $employee->id,
                                        'date_start' => $p->format('Y-m-d'),
                                        'date_end' => $p->format('Y-m-d'),
                                        'note' => 'CUTI AUTO APPROVE SYSTEM',
                                        'status' => 'accept'
                                    ]);
                                }



                                // $jumlah_hari_cuti

                                //cari cutinya belum
                            }
                        }


                        $new_at_tidak_hadir  = Attendance::firstOrCreate([
                            'employee_id' => $employee_id,
                            'date' => $p->format('Y-m-d'),
                        ]);



                        $new_at_tidak_hadir->update([
                            'is_absen' => $is_absen,
                            // 'employee_id' => $employee->id,
                            // 'date' => $p->format('Y-m-d'),
                            'cloud_id' => 'TIDAK HADIR',
                            'pin' => 'TIDAK HADIR',
                            'roster_daily_id' => $roster_daily->id ?? null,
                            'roster_status_initial' => $roster_daily->roster_status_initial ?? null
                        ]);
                        // AttendancePayrol::create([
                        //     ''
                        // ]);
                    }
                }

                $total_tambahan_dari_sa = 0;
                $sa_percents =  salaryAdjustmentDetail::whereMonth('month_start', $tanggal_tambahan_lain->format('m'))
                    ->whereYear('month_start', $tanggal_tambahan_lain->format('Y'))
                    // ->where('type_amount','nominal')
                    ->where('type_time', 'base_time')
                    ->where('employee_id', $employee->id)
                    ->get();

                foreach ($sa_percents as $key => $v) {

                    if ($v->type_amount == 'nominal') {
                        $total_tambahan_dari_sa += $v->amount;
                    } else {
                        $total_tambahan_dari_sa += ($v->amount / 100) * $employee->basic_salary;
                    }
                }



                // $sa_percents =  salaryAdjustmentDetail::whereMonth('month_start',$tanggal_tambahan_lain->format('m'))
                // ->whereYear('month_start',$tanggal_tambahan_lain->format('Y'))
                // ->where('type_amount','percent')
                // ->where('type_time','base_time')
                // ->where('employee_id',$employee->id)
                // ->get();

                // foreach ($sa_percents as $key => $v) {
                //     $total_tambahan_dari_sa += ($v->amount/100) * $employee->basic_salary;
                // }

                $sa_percents =  salaryAdjustmentDetail::whereNull('is_thr')->whereDate('month_start', '>=', $tanggal_tambahan_lain)
                    ->whereDate('month_end', '<=', $tanggal_tambahan_lain)
                    // ->where('type_amount','percent')
                    ->where('type_time', 'base_time')
                    ->where('employee_id', $employee->id)
                    ->get();

                foreach ($sa_percents as $key => $v) {

                    if ($v->type_amount == 'nominal') {
                        $total_tambahan_dari_sa += $v->amount;
                    } else {
                        $total_tambahan_dari_sa += ($v->amount / 100) * $employee->basic_salary;
                    }
                }


                $sa_percents =  salaryAdjustmentDetail::whereNull('is_thr')->whereNull('month_start')
                    ->whereNull('month_end')
                    ->where('type_time', 'forever')
                    ->where('employee_id', $employee->id)
                    ->get();

                foreach ($sa_percents as $key => $v) {

                    if ($v->type_amount == 'nominal') {
                        $total_tambahan_dari_sa += $v->amount;
                    } else {
                        $total_tambahan_dari_sa += ($v->amount / 100) * $employee->basic_salary;
                    }
                }


                $jumlah_thr = 0;
                $sa_percents =  salaryAdjustmentDetail::where('is_thr',1)->whereDate('month_start', '>=', $tanggal_tambahan_lain)
                    ->whereDate('month_end', '<=', $tanggal_tambahan_lain)
                    // ->where('type_amount','percent')
                    ->where('type_time', 'base_time')
                    ->where('employee_id', $employee->id)
                    ->get();

                foreach ($sa_percents as $key => $v) {

                    if ($v->type_amount == 'nominal') {
                        $jumlah_thr += $v->amount;
                    } else {
                        $jumlah_thr += ($v->amount / 100) * $employee->basic_salary;
                    }
                }





                $jumlah_hari_kerja  = $jumlah_hari_kerja_tmp;
                $pendapatan_tambahan_lain_lain = $total_tambahan_dari_sa;

                // $jumlah_jam_rate_lembur = 109.0; //contoh
                // $pendapatan_tambahan_lain_lain = 2645923; //contoh
                // $jumlah_hari_kerja = 20; //contoh


                $pendapatan_uang_makan = $jumlah_hari_kerja * $employee->meal_allowance_per_attend;
                $pendapatan_lembur = $jumlah_jam_lembur_tmp * $employee->overtime_rate_per_hour;

                $jumlah_pendapatan = $employee->basic_salary + $employee->allowance + $pendapatan_uang_makan + $pendapatan_lembur + $pendapatan_tambahan_lain_lain;



                $jht_perusahaan_persen = 0;
                $jht_karyawan_persen = 0;
                $jht_perusahaan_rupiah = 0;
                $jht_karyawan_rupiah = 0;

                if ($employee->bpjs_jht == 'Y') {
                    $jht_perusahaan_persen  = $bpjs_jht->company_percent ?? 0;
                    $jht_karyawan_persen    = $bpjs_jht->employee_percent ?? 0;
                    $jht_perusahaan_rupiah  = $bpjs_jht->company_nominal ?? 0;
                    $jht_karyawan_rupiah    = $bpjs_jht->employee_nominal ?? 0;
                }

                $jkk_perusahaan_persen = 0;
                $jkk_karyawan_persen = 0;
                $jkk_perusahaan_rupiah = 0;
                $jkk_karyawan_rupiah = 0;



                if ($employee->bpjs_jkk == 'Y') {
                    $jkk_perusahaan_persen  = $bpjs_jkk->company_percent ?? 0;
                    $jkk_karyawan_persen    = $bpjs_jkk->employee_percent ?? 0;
                    $jkk_perusahaan_rupiah  = $bpjs_jkk->company_nominal ?? 0;
                    $jkk_karyawan_rupiah    = $bpjs_jkk->employee_nominal ?? 0;
                }

                $jkm_perusahaan_persen = 0;
                $jkm_karyawan_persen = 0;
                $jkm_perusahaan_rupiah = 0;
                $jkm_karyawan_rupiah = 0;




                if ($employee->bpjs_jkm == 'Y') {
                    $jkm_perusahaan_persen  = $bpjs_jkm->company_percent ?? 0;
                    $jkm_karyawan_persen    = $bpjs_jkm->employee_percent ?? 0;
                    $jkm_perusahaan_rupiah  = $bpjs_jkm->company_nominal ?? 0;
                    $jkm_karyawan_rupiah    = $bpjs_jkm->employee_nominal ?? 0;
                }


                $jp_perusahaan_persen = 0;
                $jp_karyawan_persen = 0;
                $jp_perusahaan_rupiah = 0;
                $jp_karyawan_rupiah = 0;




                if ($employee->bpjs_jp == 'Y') {
                    $jp_perusahaan_persen  = $bpjs_jp->company_percent ?? 0;
                    $jp_karyawan_persen    = $bpjs_jp->employee_percent ?? 0;
                    $jp_perusahaan_rupiah  = $bpjs_jp->company_nominal ?? 0;
                    $jp_karyawan_rupiah    = $bpjs_jp->employee_nominal ?? 0;
                }

                $bpjs_perusahaan_persen = 0;
                $bpjs_karyawan_persen = 0;
                $bpjs_perusahaan_rupiah = 0;
                $bpjs_karyawan_rupiah = 0;

                if ($employee->bpjs_kes == 'Y') {
                    $kes_perusahaan_persen  = $bpjs_kes->company_percent ?? 0;
                    $kes_karyawan_persen    = $bpjs_kes->employee_percent ?? 0;
                    $kes_perusahaan_rupiah  = $bpjs_kes->company_nominal ?? 0;
                    $kes_karyawan_rupiah    = $bpjs_kes->employee_nominal ?? 0;
                }


                $total_bpjs_perusahaan_persen = $jht_perusahaan_persen + $jkk_perusahaan_persen + $jkm_perusahaan_persen + $jp_perusahaan_persen + $kes_perusahaan_persen;
                $total_bpjs_karyawan_persen = $jht_karyawan_persen + $jkk_karyawan_persen + $jkm_karyawan_persen + $jp_karyawan_persen + $kes_karyawan_persen;
                $total_bpjs_perusahaan_rupiah = $jht_perusahaan_rupiah + $jkk_perusahaan_rupiah + $jkm_perusahaan_rupiah + $jp_perusahaan_rupiah + $kes_perusahaan_rupiah;
                $total_bpjs_karyawan_rupiah = $jht_karyawan_rupiah + $jkk_karyawan_rupiah + $jkm_karyawan_rupiah + $jp_karyawan_rupiah + $kes_karyawan_rupiah;



                $ptkp = 0;

                if ($employee->ptkp == 'TK/0') {
                    $ptkp = 54000000;
                }

                if ($employee->ptkp == 'TK/1') {
                    $ptkp = 58500000;
                }

                if ($employee->ptkp == 'TK/2') {
                    $ptkp = 63000000;
                }

                if ($employee->ptkp == 'TK/3') {
                    $ptkp = 67500000;
                }

                if ($employee->ptkp == 'K/0') {
                    $ptkp = 58500000;
                }

                if ($employee->ptkp == 'K/1') {
                    $ptkp = 63000000;
                }

                if ($employee->ptkp == 'K/2') {
                    $ptkp = 67500000;
                }

                if ($employee->ptkp == 'K/3') {
                    $ptkp = 72000000;
                }

                if ($employee->ptkp == 'K/I/0') {
                    $ptkp = 112500000;
                }

                if ($employee->ptkp == 'K/I/1') {
                    $ptkp = 117000000;
                }

                if ($employee->ptkp == 'K/I/2') {
                    $ptkp = 121500000;
                }

                if ($employee->ptkp == 'K/I/3') {
                    $ptkp = 126000000;
                }


                $pemotongan_bpjs_dibayar_karyawan  = $total_bpjs_karyawan_rupiah;

                $pemotongan_tidak_hadir  = $jumlah_hari_tidak_masuk_tmp *  ($employee->basic_salary / 26);

                $pemotongan_potongan_lain_lain = 0;




                // SalaryAdvanceDetail



                $pajak_gaji_kotor_kurang_potongan = $jumlah_pendapatan - ($pemotongan_potongan_lain_lain + $pemotongan_tidak_hadir);
                $pajak_bpjs_dibayar_perusahaan = $total_bpjs_perusahaan_rupiah;


                $pajak_total_penghasilan_kotor = $pajak_gaji_kotor_kurang_potongan + $pajak_bpjs_dibayar_perusahaan;

                $n_tahun_enter = Carbon::parse($employee->enter_date)->format('Y');
                $n_tahun_now = Carbon::now()->format('Y'); 

                $jumlah_bulan_kerja = 12;


                // 2023  < 2022
                if($n_tahun_now <= $n_tahun_enter ){
                    $jumlah_bulan_kerja  = 13 - Carbon::parse($employee->enter_date)->format('m') ;
                }
                
                // $enter_month = ;

                // if($enter_month > 1){
                //     $jumlah_bulan_kerja = 13 - $enter_month;
                // }


                $pajak_biaya_jabatan = min(500000, (0.05 * $pajak_total_penghasilan_kotor)) * $jumlah_bulan_kerja;
                $pajak_bpjs_dibayar_karyawan = $total_bpjs_karyawan_rupiah;
                $pajak_total_pengurang = $pajak_biaya_jabatan + $pajak_bpjs_dibayar_karyawan;

                 //////////////////////////////////////////////////////////////
                ////// JIKA BULAN DESEMBER //////////////////


                $gaji_jan_nov               = 0;
                $gaji_des                   = 0;
                $pph_yang_dipotong_jan_nov  = 0;
                $pph_yang_dipotong_des      = 0;

                $now_bulan = Carbon::parse($period_payroll->period)->format('m');
                $now_tahun = Carbon::parse($period_payroll->period)->format('Y');
                if ($now_bulan == '12') {
                    Payroll::whereDate('date', '>=', $now_tahun.'-01-01')
                    ->whereDate('date', '<=', $now_tahun.'-11-30')
                    ->get();
                }else{
                    $pajak_gaji_bersih_setahun = (($pajak_total_penghasilan_kotor * $jumlah_bulan_kerja)  - $pajak_total_pengurang);
                }


                


                $pkp_setahun = $pajak_gaji_bersih_setahun - $ptkp;


                //menghitung pkp 5%
                $pkp_lima_persen  = \max(0, $pkp_setahun > 60000000 ? ((60000000 - 0) * 0.05) : (($pkp_setahun - 0) * 0.05));
                $pkp_lima_belas_persen  = \max(0, $pkp_setahun > 250000000 ? ((250000000 - 60000000) * 0.15) : (($pkp_setahun - 60000000) * 0.15));
                $pkp_dua_puluh_lima_persen  = \max(0, $pkp_setahun > 500000000 ? ((500000000 - 250000000) * 0.25) : (($pkp_setahun - 250000000) * 0.25));
                $pkp_tiga_puluh_persen  = \max(0, $pkp_setahun > 1000000000 ? ((1000000000 - 500000000) * 0.30) : (($pkp_setahun - 500000000) * 0.30));

                $pajak_pph_dua_satu_setahun = $pkp_lima_persen + $pkp_lima_belas_persen + $pkp_dua_puluh_lima_persen + $pkp_tiga_puluh_persen;

                $pemotongan_pph_dua_satu = $pajak_pph_dua_satu_setahun / $jumlah_bulan_kerja;
                $jumlah_pemotongan = $pemotongan_bpjs_dibayar_karyawan + $pemotongan_pph_dua_satu + $pemotongan_potongan_lain_lain;
                $gaji_bersih = $jumlah_pendapatan - $jumlah_pemotongan;


                ///////////////////////////////////////////////////////////////////
                /////////////////////PERHITUNGAN KHUSUS THR///////////////////////

                // $jumlah_thr = 0;
                $pkp_thr_setahun = 0;
                $pkp_lima_persen_thr = 0;
                $pkp_lima_belas_persen_thr = 0;
                $pkp_dua_puluh_lima_persen_thr = 0;
                $pkp_tiga_puluh_persen_thr = 0;
                $pajak_pph_dua_satu_setahun_thr = 0;
                $total_pph_dipotong = 0;


                if ($jumlah_thr > 0) {
                    // $jumlah_thr = 2000000;
                    $pkp_thr_setahun = $jumlah_thr - $pajak_biaya_jabatan - $ptkp;
                    /////--------------
                    //menghitung pkp 5%
                    $pkp_lima_persen_thr  = \max(0, $pkp_thr_setahun > 60000000 ? ((60000000 - 0) * 0.05) : (($pkp_thr_setahun - 0) * 0.05));
                    $pkp_lima_belas_persen_thr  = \max(0, $pkp_thr_setahun > 250000000 ? ((250000000 - 60000000) * 0.15) : (($pkp_thr_setahun - 60000000) * 0.15));
                    $pkp_dua_puluh_lima_persen_thr  = \max(0, $pkp_thr_setahun > 500000000 ? ((500000000 - 250000000) * 0.25) : (($pkp_thr_setahun - 250000000) * 0.25));
                    $pkp_tiga_puluh_persen_thr  = \max(0, $pkp_thr_setahun > 1000000000 ? ((1000000000 - 500000000) * 0.30) : (($pkp_thr_setahun - 500000000) * 0.30));

                    $pajak_pph_dua_satu_setahun_thr = $pkp_lima_persen_thr + $pkp_lima_belas_persen_thr + $pkp_dua_puluh_lima_persen_thr + $pkp_tiga_puluh_persen_thr;

                    $total_pph_dipotong = $pajak_pph_dua_satu_setahun - $pajak_pph_dua_satu_setahun_thr;
                }


                ////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////




               





                $new_payroll = Payroll::firstOrCreate([
                    'employee_id' => $employee->id,
                    'period_payroll_id' => $period_payroll->id,
                ]);


                /////////simulasi naik gaji

                if ($period_payroll->period == '2022-06-01' && $employee->id == 1) {
                    $employee->basic_salary = 4000000;
                    $employee->save();
                }


                $new_payroll->update([
                    'pendapatan_gaji_dasar' => $employee->basic_salary,
                    'pendapatan_tunjangan_tetap' => $employee->allowance,
                    'pendapatan_uang_makan' => $pendapatan_uang_makan,
                    'pendapatan_lembur' => $pendapatan_lembur,
                    'pendapatan_tambahan_lain_lain' => $pendapatan_tambahan_lain_lain,
                    'jumlah_pendapatan' => $jumlah_pendapatan,
                    'pajak_pph_dua_satu_setahun' => $pajak_pph_dua_satu_setahun,


                    // 'pemotongan_bpjs_dibayar_karyawan' => 0,
                    // 'pemotongan_pph_dua_satu' => 0,
                    // 'pemotongan_potongan_lain_lain' => 0,
                    // 'jumlah_pemotongan' => 0,

                    'gaji_bersih' => $gaji_bersih - $jumlah_hutang,
                    'bulan' => $period_payroll->period,
                    'posisi' => "",
                    'gaji_dasar' => $employee->basic_salary,
                    'tunjangan_tetap' => $employee->allowance,


                    'rate_lembur' => $employee->overtime_rate_per_hour,
                    'jumlah_jam_rate_lembur' => $jumlah_jam_lembur_tmp,

                    'tunjangan_makan' => $employee->meal_allowance_per_attend,
                    'jumlah_hari_tunjangan_makan' => $jumlah_hari_kerja,



                    'tunjangan_transport' => $employee->transport_allowance_per_attend,
                    'jumlah_hari_tunjangan_transport' => $jumlah_hari_kerja,



                    'tunjangan_kehadiran' => $employee->attend_allowance_per_attend,
                    'jumlah_hari_tunjangan_kehadiran' => $jumlah_hari_kerja,


                    'ptkp_karyawan' => $ptkp,
                    'jumlah_cuti_ijin_per_bulan' => 0,
                    'sisa_cuti_tahun' => 0,

                    'dasar_updah_bpjs_tk' => $bpjs_dasar_updah_bpjs_tk,
                    'dasar_updah_bpjs_kes' => $dasar_updah_bpjs_kes,



                    'jht_perusahaan_persen' => $jht_perusahaan_persen,
                    'jht_karyawan_persen' => $jht_karyawan_persen,
                    'jht_perusahaan_rupiah' => $jht_perusahaan_rupiah,
                    'jht_karyawan_rupiah' => $jht_karyawan_rupiah,

                    'jkk_perusahaan_persen' => $jkk_perusahaan_persen,
                    'jkk_karyawan_persen' => $jkk_karyawan_persen,
                    'jkk_perusahaan_rupiah' => $jkk_perusahaan_rupiah,
                    'jkk_karyawan_rupiah' => $jkk_karyawan_rupiah,

                    'jkm_perusahaan_persen' => $jkm_perusahaan_persen,
                    'jkm_karyawan_persen' => $jkm_karyawan_persen,
                    'jkm_perusahaan_rupiah' => $jkm_perusahaan_rupiah,
                    'jkm_karyawan_rupiah' => $jkm_karyawan_rupiah,

                    'jp_perusahaan_persen' => $jp_perusahaan_persen,
                    'jp_karyawan_persen' => $jp_karyawan_persen,
                    'jp_perusahaan_rupiah' => $jp_perusahaan_rupiah,
                    'jp_karyawan_rupiah' => $jp_karyawan_rupiah,

                    'bpjs_perusahaan_persen' => $bpjs_perusahaan_persen,
                    'bpjs_karyawan_persen' => $bpjs_karyawan_persen,
                    'bpjs_perusahaan_rupiah' => $bpjs_perusahaan_rupiah,
                    'bpjs_karyawan_rupiah' => $bpjs_karyawan_rupiah,

                    'total_bpjs_perusahaan_persen' => $total_bpjs_perusahaan_persen,
                    'total_bpjs_karyawan_persen' => $total_bpjs_karyawan_persen,
                    'total_bpjs_perusahaan_rupiah' => $total_bpjs_perusahaan_rupiah,
                    'total_bpjs_karyawan_rupiah' => $total_bpjs_karyawan_rupiah,


                    'jumlah_pemotongan' => $jumlah_pemotongan + $jumlah_hutang,

                    'pemotongan_bpjs_dibayar_karyawan' => $pemotongan_bpjs_dibayar_karyawan,
                    'pemotongan_pph_dua_satu' => $pemotongan_pph_dua_satu,
                    'pemotongan_potongan_lain_lain' => $pemotongan_potongan_lain_lain + $jumlah_hutang,


                    'pajak_gaji_kotor_kurang_potongan' => $pajak_gaji_kotor_kurang_potongan,
                    'pajak_bpjs_dibayar_perusahaan' => $pajak_bpjs_dibayar_perusahaan,
                    'pajak_total_penghasilan_kotor' => $pajak_total_penghasilan_kotor,
                    'pajak_biaya_jabatan' => $pajak_biaya_jabatan,
                    'pajak_bpjs_dibayar_karyawan' => $pajak_bpjs_dibayar_karyawan,
                    'pajak_total_pengurang' => $pajak_total_pengurang,
                    'pajak_gaji_bersih_setahun' => $pajak_gaji_bersih_setahun,
                    'pkp_setahun' => $pkp_setahun,

                    'pkp_lima_persen' => $pkp_lima_persen,
                    'pkp_lima_belas_persen' => $pkp_lima_belas_persen,
                    'pkp_dua_puluh_lima_persen' => $pkp_dua_puluh_lima_persen,
                    'pkp_tiga_puluh_persen' => $pkp_tiga_puluh_persen,



                    'jumlah_thr' => $jumlah_thr,
                    'pkp_thr_setahun' => $pkp_thr_setahun,
                    'pkp_lima_persen_thr' => $pkp_lima_persen_thr,
                    'pkp_lima_belas_persen_thr' => $pkp_lima_belas_persen_thr,
                    'pkp_dua_puluh_lima_persen_thr' => $pkp_dua_puluh_lima_persen_thr,
                    'pkp_tiga_puluh_persen_thr' => $pkp_tiga_puluh_persen_thr,
                    'pajak_pph_dua_satu_setahun_thr' => $pajak_pph_dua_satu_setahun_thr,
                    'total_pph_dipotong' => $total_pph_dipotong,


                    'gaji_jan_nov'=>$gaji_jan_nov,
                    'gaji_des'=>$gaji_des,
                    'pph_yang_dipotong_jan_nov'=>$pph_yang_dipotong_jan_nov,
                    'pph_yang_dipotong_des'=>$pph_yang_dipotong_des,

                    'jumlah_hutang'=>$jumlah_hutang,
                    'pemotongan_tidak_hadir'=>$pemotongan_tidak_hadir,
                ]);

                AttendancePayrol::whereDate('date', '>=', $period_payroll->date_start)
                    ->whereDate('date', '<=', $period_payroll->date_end)
                    ->where('employee_id', $employee->id)
                    // ->where(function ($query) {
                    //     $query->where('hour_start', '!=', NULL)->orWhere('hour_end', '!=', NULL);
                    // })
                    ->update([
                        'payroll_id' => $new_payroll->id
                    ]);
            }


            $unik_name_excel = 'Periode_' . $period_payroll->period . '_' . Str::uuid() . '.xlsx';

            $period_payroll->update([
                'last_excel' => $unik_name_excel,
                'last_excel_cv_kpt' => "cv_kpt_" . $unik_name_excel,
                'last_excel_pt_kpt' => "cv_kpt_" . $unik_name_excel,

            ]);



            DB::commit();

            Excel::store(new PayrollExport($period_payroll, $employees), $unik_name_excel, 'local');

            Excel::store(new PayrollExport($period_payroll, $employees), "cv_kpt_" . $unik_name_excel, 'local');
            Excel::store(new PayrollExport($period_payroll, $employees), "cv_kpt_" . $unik_name_excel, 'local');


            print("SUUCESS GENERATED \n");


            return true;
            // return response()->json([
            //     'success' => true,
            //     'message' => "Berhasil {$message}",
            // ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            print_r([$e->getMessage(), $e->getLine()]);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);

            return false;


            // return response()->json([
            //     'success' => false,
            //     'message' => "Gagal {$message} {$e->getMessage()}",
            //     'error' => [$e->getMessage(), $e->getTrace(), $e->getLine()]
            // ], 500);
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

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }

    function export()
    {
        $path = storage_path('app\\' . request()->get('a'));
        return response()->download($path);
    }
}
