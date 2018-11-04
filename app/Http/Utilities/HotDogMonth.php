<?php

namespace App\Http\Utilities;

use App\User;
use App\HotDogDay;
use Carbon\Carbon;

class HotDogMonth
{

    public $thisMonth = [];

    /**
     * This returns statically a collection
     * of Hot Dog Days during current month
     *
     * @return collection
     *
     */
    public static function whatDays()
    {
        $now = Carbon::now('America/Chicago');
        $nextOccuringTuesday = new Carbon('next tuesday this month America/Chicago');
        $dueDate = $nextOccuringTuesday->copy()->subDays(4)->setTime(8, 15, 0);
        $lastTuesdayOfMonth = new Carbon('last tuesday of this month America/Chicago');

        if(($now > $dueDate) && ( $dueDate->copy()->diffInDays($lastTuesdayOfMonth->copy()->setTime(8,15,0) ) < 4 ) ) {
            $nextOccuringTuesday = new Carbon('first tuesday of next month America/Chicago');
            $dueDate = $nextOccuringTuesday->copy()->setTime(8, 15, 0)->subDays(4);
            $lastTuesdayOfMonth = new Carbon('last tuesday of next month America/Chicago');
        } elseif($now > $dueDate) {
            $nextOccuringTuesday = $nextOccuringTuesday->addDays(7);
        }

        $nextHotDogDays = HotDogDay::where('event_date', '>=', $nextOccuringTuesday)
            ->where('event_date', '<=', $lastTuesdayOfMonth)
            ->orderBy('event_date')
            ->get();

        return $nextHotDogDays;
    }

    /**
     * This returns statically a collection
     * of Hot Dog Days during current month
     *
     * @return Carbon instance
     *
     */
    public static function dueDate() {
        $now = Carbon::now('America/Chicago');
        $nextOccuringTuesday = new Carbon('next tuesday this month America/Chicago');
        $dueDate = $nextOccuringTuesday->copy()->subDays(4)->setTime(8, 15, 0);
        if($now > $dueDate) {
            $nextOccuringTuesday = $nextOccuringTuesday->addDays(7);
            $dueDate = $nextOccuringTuesday->copy()->subDays(4)->setTime(8, 15, 0);
        }
        return $dueDate;
    }
}
