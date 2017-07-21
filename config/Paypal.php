<?php


return [


    'Account' => [
        'ClientId' => 'AX8tKJIyiDbL7AET05iNTlERKFK1HL9Vv2U6vt3anQfVBSdE-53EzthrAjtuGAUZxLdQ5WkwHdgprNIj',
        'ClientSecret' => 'EGlmigqe4GlvJ3H6IyhKpb1Cx9DuruScckm-wE1fYouORjD3nrmc3LLkbZQahs0Iy4A5j-oejAQ5q1HK',
    ],

    'Setting' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => '30',
        'log.LogEnable' => true,
        'logFileName' => public_path().'/logs/paypal.log',
        'log.LogLevel' => 'FINE',
    ],

];
