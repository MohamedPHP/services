<?php


return [


    'Account' => [
        'ClientId' => 'AX8tKJIyiDbL7AET05iNTlERKFK1HL9Vv2U6vt3anQfVBSdE-53EzthrAjtuGAUZxLdQ5WkwHdgprNIj',
        'ClientSecret' => 'EIoCrawExabFpjOuMA3ovrj49L7DmedGXNXtmxUCOsVoHgbqAX6HfVtdcAYx0zxCbLPUo9u9QjicYUG_',
    ],

    'Setting' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => '30',
        'log.LogEnable' => true,
        'logFileName' => public_path().'/logs/paypal.log',
        'log.LogLevel' => 'FINE',
    ],

];
