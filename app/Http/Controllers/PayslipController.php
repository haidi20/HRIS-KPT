<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PeriodPayroll;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    function index() {
        

        $employees = Employee::select('id','name','position_id')->get();
        $compact = compact('employees');
        return view("pages.payroll.pay_slip.index", $compact);
    }


    function store() {
        

        $bulan =  request()->get('bulan');
        $tahun =  request()->get('tahun');


        $employee_id =  request()->get('employee_id');


        $periode_payroll = PeriodPayroll::whereMonth('period',$bulan)->whereYear('period',$tahun)->first();

        if(!isset($periode_payroll->id)){
            $periode_payroll = PeriodPayroll::create([
                'period'=> $tahun."-".$bulan."-01"
            ]);
        }
        $payroll = Payroll::where('employee_id',$employee_id)->where('period_payroll_id',$periode_payroll->id)
        ->get();

        return [$periode_payroll,$payroll];

    }



}

