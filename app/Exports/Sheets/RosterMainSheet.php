<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('signature');
    //     $drawing->setDescription('This is my signature');
    //     $drawing->setPath(public_path('/assets/img/logo.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('A1');

    //     return $drawing;
    // }

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
