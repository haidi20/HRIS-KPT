<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;

class RosterMainSheet implements FromView, WithTitle, ShouldAutoSize, WithStyles
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
        return 'UTAMA';
    }

    public function view(): View
    {
        return view('pages.roster.exports.main', [
            'data' => $this->data,
            'dates' => $this->dates,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }
}
