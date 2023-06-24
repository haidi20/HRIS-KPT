<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PayrollExportPerEmployee implements FromView,WithTitle
{

    protected  $period_payroll= null;
    protected  $employees= null;

    public function __construct($period_payroll,$employees) {
        $this->period_payroll = $period_payroll;
        $this->employees = $employees;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('pages.period_payroll.exports', [
            'invoices' => 'a'
        ]);
    }

    public function title(): string
    {
        return $this->employees->name ?? 'no-name';
    }
}
