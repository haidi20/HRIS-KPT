<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new PayrollExportPerEmployee();
        }

        return $sheets;
    }

    
}
