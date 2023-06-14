<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class OvertimeExport implements FromView, WithTitle, WithStyles, ShouldAutoSize, WithDrawings
{

    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Surat Perintah Lembur';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('This is logo');
        $drawing->setPath(public_path('/assets/img/logo.png'));
        $drawing->setHeight(45);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function view(): View
    {
        return view('pages.overtime-report.partials.export', [
            'data' => $this->data,
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
