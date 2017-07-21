<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConfigurationException;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
// needed for paypal
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use App\Paypal;

use Auth;

class PaypalController extends Controller
{

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


    public function GetPaymentInfoById($id) {
        $pay = Payment::get($id, $this->_apiContext);
        return $pay;
    }


}
