<?php


return [


    'Account' => [
        'ClientId' => 'AUjnQRPfaAGUc8V2HaADm4ICpEzgsT6SZD5IOz3iVNG5czFVlQ9suPVV-K96iCWRdsbZ_Ix4CT4rzx0-',
        'ClientSecret' => 'EFgOFGSFW_AEwVEpX-3JUUVi3-xSv-vSyYuUzgSqNVXdaOVNjX5jkRZ4H87-lTKcROrDzoIYYCgb0N-_',
    ],

    'Setting' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => '30',
        'log.LogEnable' => true,
        'logFileName' => public_path().'/logs/paypal.log',
        'log.LogLevel' => 'FINE',
    ],

];
