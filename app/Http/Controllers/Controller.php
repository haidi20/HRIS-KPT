<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Compute a range between two dates, and generate
     * a plain array of Carbon objects of each day in it.
     *
     * @param  string  $yearMonth
     * @param  bool  $inclusive
     * @return array|null
     */
    function dateRange(string $yearMonth, $inclusive = true)
    {
        $from = Carbon::parse($yearMonth)->format("Y-m-01");
        $from = Carbon::parse($from);
        $to = Carbon::parse($yearMonth)->format("Y-m-") . Carbon::parse($yearMonth)->daysInMonth;
        $to = Carbon::parse($to);

        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            // $from->addDay();
            $to->addDay();
            // $to->addDay();
        }

        $step = CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = Carbon::parse(new Carbon($day))->format("Y-m-d");
        }

        return !empty($range) ? $range : null;
    }
}
