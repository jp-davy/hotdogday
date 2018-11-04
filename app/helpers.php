<?php
function flash($title = null, $message = null)
{
    $flash = app(\App\Http\Flash::class);

    if (func_num_args() == 0) {
        return $flash;
    }
    return $flash->info($title, $message);
}



function customerPreferences($key = null)
{
    $customerPreference = app(\App\CustomerPreference::class);
    return $key ? data_get($customerPreference->preferences, $key, null) : $customerPreference;
}
