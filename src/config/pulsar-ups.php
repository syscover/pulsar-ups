<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UPS Credentials
    |--------------------------------------------------------------------------
    |
    | This option specifies the UPS credentials for your account.
    | You can put it here but I strongly recommend to put thoses settings into your
    | .env & .env.example file.
    |
    */
    'access_key'    => env('UPS_ACCESS_KEY', 'test'),
    'user'          => env('UPS_USER', 'test'),
    'password'      => env('UPS_PASSWORD', 'test'),
    'sandbox'       => env('UPS_SANDBOX', true),


    'country_codes' => [
        'ES' => [
            '35***' => 'IC',
            '38***' => 'IC',
        ]
    ],

    'services' => [
        'IC' => [
            '65' => ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'US' => [
            ['code' => '07',    'name' =>'UPS Express',                        'saver' => false],
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '54',    'name' =>'UPS Express Plus',                   'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true],
            ['code' => '96',    'name' =>'UPS Worldwide Express Freight',      'saver' => false]
        ]
    ],
];