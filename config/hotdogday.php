<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HOT DOG DAY CONFIG VARIABLES
    |--------------------------------------------------------------------------
    | MEAL PRICE AND EXTRA DOG PRICE STORED IN CENTS
    |
    */
    'pay_online_url' => env('PAY_ONLINE_URL','https://example.com'),
    'meal_price' => env('MEAL_PRICE',400),
    'extra_price' => env('EXTRA_PRICE',100),
    'mail_from_email' => [
        'email_address' => env('MAIL_FROM_ADDRESS', 'noreply@hotdogday.com'),
        'name' => env('MAIL_FROM_NAME', 'Hot Dog Day'),
    ],

    'submit_to_school_email' => [
        'email_address' => env('SUBMIT_TO_MAIL_ADDRESS', 'email@example.com'),
        'name' => env('SUBMIT_TO_MAIL_NAME', 'Recipient Name'),
    ],

];
