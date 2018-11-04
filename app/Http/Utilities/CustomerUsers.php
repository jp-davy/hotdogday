<?php

namespace App\Http\Utilities;

use App\User;
use Carbon\Carbon;

class CustomerUsers
{

    
    /**
     * This returns statically the list of customer
     * users
     *
     * @return collection
     *
     */
    public static function allUsers($customer_no)
    {
        $users = User::where('sage_customer_no', $customer_no)->get();
        return $users;
    }
}
