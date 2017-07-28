<?php


return [


    'Account' => [
        'ClientId' => '',
        'ClientSecret' => '',
    ],

    'Setting' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => '30',
        'log.LogEnable' => true,
        'logFileName' => public_path().'/logs/paypal.log',
        'log.LogLevel' => 'FINE',
    ],

];
