# Developer Notes
To Understand The Payment Processes [ Profit Distribution System ]  Go To [ app/http/controllers/OrdersController ] at line 33

to disable the larvel depuger go to config/app.php line 29 and make it false

# For The Site Schadualing
for the schadualing i used [fightbulc]https://packagist.org/packages/fightbulc/moment).

# For The Paypal Payment

1- Create Developer Accout In Paypal.
2- Create App In Paypal.
3- Make PHP File Into config folder in the laravel project and puth this code into it
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

4- get the ClientId and ClientSecret From Paypal dashboard.
5- In The ClientId Key In Accounts Array will have ClientId from dashboard
6- In The ClientSecret Key In Accounts Array will have ClientSecret from dashboard
7- create form with price field then create route and controller put these functions into it
```php
private $_apiContext;

public function contextPaypal() {
    // config == Config files
    // Client Id
    $ClientId = config('Paypal.Account.ClientId');
    // Client Secret
    $ClientSecret = config('Paypal.Account.ClientSecret');
    // Came from Paypal SDK
    $OAuth = new OAuthTokenCredential($ClientId, $ClientSecret);
    // Came from Paypal SDK
    $this->_apiContext = new ApiContext($OAuth);
    // Account Connection && Log Setting
    $SetConfig = config('Paypal.Setting');
    // Set And Apply The Configration
    $this->_apiContext->setConfig($SetConfig);
}

public function AddCreditNow(Request $request) {

    $this->validate($request, [
        'price' => 'required|numeric|max:999',
    ]);

    $this->contextPaypal();

    $price = $request->price;


    // set the payment method
    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    // set the currency and the price
    $amount = new Amount();
    $amount->setCurrency("USD")->setTotal($price);

    // make the trancaction [العملية التجارية]
    $transaction = new Transaction();
    $transaction->setAmount($amount);

    $baseUrl = url('/');
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("$baseUrl?success=true")->setCancelUrl("$baseUrl?success=false");

    $payment = new Payment();
    $payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));

    $request = clone $payment;
    $curl_info = curl_version();

    try {
        $payment->create($this->_apiContext);

        // note this is the table i use to store payments you can do it as you like
        // $pay = new Paypal();
        // $pay->pay_id = $payment->id;
        // $pay->user_id = Auth::user()->id;
        // $pay->payment_method = $payment->payer->payment_method;
        // $pay->state = $payment->state;
        // $pay->price = $price;
        // if ($pay->save()) {
        //     return [
        //         'status'  => 'done',
        //     ];
        // } else {
        //     abort(403);
        // }

    } catch (PayPalConnectionException $ex) {
        echo $ex->getCode();
        echo $ex->getData();
    }

    $redirect = null;
    foreach ($payment->getLinks() as $link) {
        if ($link->getRel() == 'approval_url'){
            $redirect = $link->getHref();
        }
    }

    if ($redirect != null){
        return Redirect::away($redirect);
    }else{
        abort(403);
    }

}
```
8 - i think i am done for now :)
