<?php

namespace App\Traits\Functions;

use Carbon\Carbon;

trait RandomTrait
{
    /**
     * Returns a random element from the passed arguments.
     *
     * @param $parameters
     * @return mixed|null
     */
    public static function getRandom(...$parameters)
    {
        if (empty($parameters)) {
            return null;
        }

        $randomIndex = array_rand($parameters);

        return $parameters[$randomIndex];
    }

    /**
     * Returns a random date in this format: 'Y-d-m H:i:s'
     *
     * @param int $startTimeInterval
     * @param int $endTimeInterval
     * @param string $timePeriod
     * @return string
     */
    function generateRandomDate(int $startTimeInterval, int $endTimeInterval, string $timePeriod = 'hours'): string
    {
        switch ($timePeriod)
        {
            case 'years':
                $minDate = Carbon::now()->subYears($startTimeInterval);
                $maxDate = Carbon::now()->subYears($endTimeInterval);
                break;
            case 'months':
                $minDate = Carbon::now()->subMonths($startTimeInterval);
                $maxDate = Carbon::now()->subMonths($endTimeInterval);
                break;
            case 'days':
                $minDate = Carbon::now()->subDays($startTimeInterval);
                $maxDate = Carbon::now()->subDays($endTimeInterval);
                break;
            case 'hours':
            default:
                $minDate = Carbon::now()->subHours($startTimeInterval);
                $maxDate = Carbon::now()->subHours($endTimeInterval);
                break;
            case 'minutes':
                $minDate = Carbon::now()->subMinutes($startTimeInterval);
                $maxDate = Carbon::now()->subMinutes($endTimeInterval);
                break;
        }

        $timestamp = mt_rand($minDate->timestamp, $maxDate->timestamp);
        return date('Y-m-d H:i:s', $timestamp);
    }


}
