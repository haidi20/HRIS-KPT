<?php

use Carbon\Carbon;

if (
    !function_exists('isActive')
) {

    /**
     * Checks if the current request path matches the given path and returns the 'active' class if true.
     *
     * @param string $path The path to check against the current request path.
     * @return string Returns 'active' if the current request path matches the given path; otherwise, an empty string.
     */

    function isActive($path)
    {
        return request()->is($path) ? 'active' : '';
    }
}

if (
    !function_exists('dateReadable')
) {

    /**
     * Format a date into a readable format using the Indonesian locale.
     *
     * @param string|\DateTimeInterface $date The date to format.
     * @return string The formatted date in the "dddd, D MMMM YYYY" format using the Indonesian locale.
     */

    function dateReadable($date)
    {
        return Carbon::parse($date)->locale('id')->isoFormat("dddd, D MMMM YYYY");
    }
}

if (
    !function_exists('dateDuration')
) {

    /**
     * Calculate the duration in days between two Carbon dates.
     *
     * @param string $date_start The start date with format Y-m-d.
     * @param string $date_end The end date with format Y-m-d.
     * @return int The duration in days.
     */
    function dateDuration($date_start, $date_end)
    {
        $getDateStart = Carbon::createFromFormat('Y-m-d', $date_start);
        $getDateEnd = Carbon::createFromFormat('Y-m-d', $date_end);

        $duration = $getDateEnd->diffInDays($getDateStart);

        return $duration;
    }
}
