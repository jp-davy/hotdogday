<?php

namespace App\Http\Utilities;

use App\User;
use App\HotDogDay;
use Carbon\Carbon;

class NextHotDogDay
{

    
    /**
     * This returns statically the list of customer
     * users
     *
     * @return collection
     *
     */
    public static function whatDay()
    {
        $now = Carbon::now();

        $nextHotDogDay = HotDogDay::where('event_date', '>=', $now)
            ->orderBy('event_date')
            ->first();

        return $nextHotDogDay->event_date;
    }
}
