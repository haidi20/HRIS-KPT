<?php

namespace App\Console\Commands;

use App\Http\Controllers\PeriodPayrollController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateGajiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate_gaji:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_now = Carbon::now();

        $periode = "";
        $date_start = "";
        $date_end = "";

        $data_period_payroll = (object) [
            "periode" => $date_now->format('Y-m'),
            "date_end" => $date_now->startOfMonth()->format('Y-m') . "-25",
            "date_start" => $date_now->startOfMonth()->addMonths(-1)->format('Y-m') . "-26",

        ];

 
        $period_payroll =  new PeriodPayrollController($data_period_payroll);
        $period_payroll->store();

        return 0;
    }
}
