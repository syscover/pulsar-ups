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
    'sandbox'           => env('UPS_SANDBOX', true),
    'user'              => env('UPS_USER', 'test'),
    'password'          => env('UPS_PASSWORD', 'test'),
    'access_key'        => env('UPS_ACCESS_KEY', 'test'),
    'shipper_number'    => env('UPS_SHIPPER_NUMBER', 'test'),

    // country codes exceptions to consider
    'country_codes' => [
        'ES' => [
            '35***' => 'IC',    // Islas Canarias
            '38***' => 'IC',    // Islas Canarias
            '51***' => 'XC',    // Ceuta
            '52***' => 'XL',    // Melilla
        ]
    ],

    // in case that a country only has any services available
    'services' => [
        'IC' => [
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'XC' => [
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'XL' => [
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'US' => [
            ['code' => '07',    'name' =>'UPS Express',                        'saver' => false],
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '54',    'name' =>'UPS Express Plus',                   'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true],
            ['code' => '96',    'name' =>'UPS Worldwide Express Freight',      'saver' => false]
        ],
        'CA' => [
            ['code' => '07',    'name' =>'UPS Express',                        'saver' => false],
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '54',    'name' =>'UPS Express Plus',                   'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true],
            ['code' => '96',    'name' =>'UPS Worldwide Express Freight',      'saver' => false]
        ],
        'IS' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'AR' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'BR' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'CL' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'CO' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'NZ' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'AU' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
        'JP' => [
            ['code' => '08',    'name' =>'UPS Expedited',                      'saver' => false],
            ['code' => '65',    'name' =>'UPS Express Saver',                  'saver' => true]
        ],
    ],
];