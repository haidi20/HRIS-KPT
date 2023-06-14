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

class RosterTotalSheet implements FromView, WithTitle, ShouldAutoSize, WithStyles, WithDrawings
{
    protected $data;
    protected $dates;
    protected $positions;

    function __construct($data, $dates, $positions)
    {
        $this->data = $data;
        $this->dates = $dates;
        $this->positions = $positions;
    }

    public function title(): string
    {
        return 'total';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('This is logo');
        $drawing->setPath(public_path('/assets/img/logo.png'));
        $drawing->setHeight(45);
        $drawing->setCoordinates('B1');

        return $drawing;
    }


    public function view(): View
    {
        return view('pages.roster.exports.total', [
            'data' => $this->data,
            'dates' => $this->dates,
            'positions' => $this->positions,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $range = 'A2:A1';
        $style = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($style);
    }
}
