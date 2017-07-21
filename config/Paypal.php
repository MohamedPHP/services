<?php


return [


    'Account' => [
        'ClientId' => 'AS6_Xp-2NuEN71S11C-w-ZyEkBzH32peDszR0ziUJDrC8hLfd4HbzxflJYW9JhJy7nJc7sM-zTC4EwyZ',
        'ClientSecret' => 'EIvxlk7NaT2K9q67NApDAAMQsEF8RZs_3HFwSq0vLkvLUoJrAJo6iNMpqc4mneJ-UGmkEbTpvSfkyrZC',
    ],

    'Setting' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => '30',
        'log.LogEnable' => true,
        'logFileName' => public_path().'/logs/paypal.log',
        'log.LogLevel' => 'FINE',
    ],

];
