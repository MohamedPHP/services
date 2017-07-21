# Developer Notes
To Understand The Payment Processes [ Profit Distribution System ]  Go To [ app/http/controllers/OrdersController ] at line 33

to disable the larvel depuger go to config/app.php line 29 and make it false

# For The Site Schadualing
for the schadualing i used [fightbulc]https://packagist.org/packages/fightbulc/moment).

# For The Paypal Payment

frist before any thing read the documentations please because of updates https://paypal.github.io/PayPal-PHP-SDK/sample/

# staps i walked through

1- Create Developer Accout In Paypal.
2- Create sandbox account.
3- Create App In Paypal and assign it to sand box account.
4- Make PHP File Into config folder in the laravel project and puth this code into it
```php
<?php
    return [


        'Account' => [
            'ClientId' => 'Your Application ClientId From Paypal',
            'ClientSecret' => 'Your Application ClientSecret From Paypal',
        ],

        'Setting' => [
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => '30',
            'log.LogEnable' => true,
            'logFileName' => public_path().'/logs/paypal.log',
            'log.LogLevel' => 'FINE',
        ],

    ];
?>
```

5- get the ClientId and ClientSecret From application you created in Paypal dashboard.
6- In The ClientId Key In Accounts Array will have ClientId from dashboard
7- In The ClientSecret Key In Accounts Array will have ClientSecret from dashboard
8- create form with price field then create route and controller put these functions into it
```php
// put this code into YourPamentController
// for less lines in readme check app/http/controllers/PaypalController
```
9 - i think i am done for now :)
