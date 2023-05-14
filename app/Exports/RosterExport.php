<?php

namespace App\Exports;

use App\Exports\Sheets\RosterMainSheet;
use App\Exports\Sheets\RosterTotalSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RosterExport implements WithMultipleSheets
{

    private $main;
    private $total;
    private $date;


    function __construct($main, $total, $date)
    {
        $this->main = $main;
        $this->total = $total;
        $this->date = $date;
    }

    public function sheets(): array
    {
        $sheets = [];

        $main = $this->main;
        $total = $this->total;
        $date = $this->date;

        $sheets[] = new RosterMainSheet($main, $date);
        $sheets[] = new RosterTotalSheet($total, $date);

        return $sheets;
    }
}
