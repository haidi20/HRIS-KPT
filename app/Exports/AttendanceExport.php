<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

class AttendanceExport implements FromView, WithTitle, WithStyles, ShouldAutoSize
{

    protected $data;
    protected $dates;

    function __construct($data, $dates)
    {
        $this->data = $data;
        $this->dates = $dates;
    }

    public function title(): string
    {
        return 'Attendance';
    }

    public function view(): View
    {
        return view('pages.attendance.partials.export', [
            'data' => $this->data,
            'dates' => $this->dates,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
