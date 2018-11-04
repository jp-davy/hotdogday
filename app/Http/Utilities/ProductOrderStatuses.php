<?php

namespace App\Http\Utilities;

use App\ProductOrderStatus;
use Carbon\Carbon;

class ProductOrderStatuses
{

    
    /**
     * This returns statically the list of post
     * statuses
     *
     * @return collection
     *
     */
    public static function allStatuses()
    {
        $statuses = ProductOrderStatus::all();
        return $statuses;
    }
}
