<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class VacationReportExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Data Cuti';
    }

    public function view(): View
    {
        return view('pages.vacation-report.partials.export', [
            'data' => $this->data,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }
}
