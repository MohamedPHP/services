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
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;


use App\Paypal;
use App\Profit;
use App\User;
use App\SiteProfit;
use Session;

use Auth;

class PaypalController extends Controller
{

    private $_apiContext;

    public function contextPaypal() {
        // config == Config files
        // Client Id
        $ClientId = config('Paypal.Account.ClientId'); // [Paypal => 'filename in contig direcotry'] [Account => 'array']
        // Client Secret
        $ClientSecret = config('Paypal.Account.ClientSecret'); // [Paypal => 'filename in contig direcotry'] [ClientSecret => 'array']
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
        $redirectUrls->setReturnUrl("$baseUrl/doneCharge?success=true")->setCancelUrl("$baseUrl/errorCharge?success=false");
        $payment = new Payment();
        $payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));
        $request = clone $payment;
        $curl_info = curl_version();
        try {
            $payment->create($this->_apiContext);
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
            session(['price' => $price]);
            return Redirect::away($redirect);
        }else{
            abort(403);
        }
    }

    public function doneCharge(Request $request) {
        if ($request->success == true && $request->paymentId && $request->token && $request->PayerID) {
            $price = session('price');
            session()->forget('price');
            $this->contextPaypal();
            // Save Payments To DB
            $payment = $this->GetPaymentInfoById($request->paymentId);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);
            $transaction = new Transaction();
            $amount = new Amount();
            $details = new Details();
            $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($price);
            $amount->setCurrency('USD');
            $amount->setTotal($price);
            $amount->setDetails($details);
            $transaction->setAmount($amount);
            $execution->addTransaction($transaction);
            try {
                $result = $payment->execute($execution, $this->_apiContext);
                $paymentInformationToDB = $this->GetPaymentInfoById($request->paymentId);
                $pay = new Paypal();
                $pay->pay_id = $paymentInformationToDB->id;
                $pay->user_id = Auth::user()->id;
                $pay->payment_method = $paymentInformationToDB->payer->payment_method;
                $pay->state = $paymentInformationToDB->state;
                $pay->price = $paymentInformationToDB->transactions[0]->amount->total;
                if ($pay->save()) {
                    return redirect('/#!/AllCharges')->with('success', 'Your Charge Has Been Successfully');
                } else {
                    return redirect('/')->with('error', 'Your Charge has not Been Successfully');
                }
            } catch (Exception $ex) {
                return redirect('/')->with('error', 'Error Happend Try Again Again');
            }
        }
        return redirect('/')->with('error', 'Error Happend Try Again Again');

    }

    public function errorCharge() {
        return redirect('/#!/AddCredit')->with('error', 'There Wan An Error During Charging Proccess If Your Balance Was Missed You Can Contact us :) ');
    }

    public function GetPaymentInfoById($id) {
        $pay = Payment::get($id, $this->_apiContext);
        return $pay;
    }

    public function profitsApprove($id) {
        $profit = Profit::find($id);

        if ($profit) {
            if ($profit->status != 0) {
                return redirect()->back()->with(['error' => 'there is some error']);
            }
            $user = User::find($profit->user_id);
            if (!$user) {
                return redirect()->back()->with(['error' => 'there is some error']);
            }

            $siteprofitPrice = $profit->price - ($profit->price * (5 / 100));

            $this->contextPaypal();

            $payouts = new \PayPal\Api\Payout();
            $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
            $senderBatchHeader->setSenderBatchId(uniqid())->setEmailSubject("You have a Payout! From Services Website");
            $senderItem = new \PayPal\Api\PayoutItem();
            $senderItem->setRecipientType('Email')
            ->setNote('Thanks for your patronage!')
            ->setReceiver($user->email)
            ->setSenderItemId("2014031400023")
            ->setAmount(new \PayPal\Api\Currency('{"value":"'.$siteprofitPrice.'", "currency":"USD"}'));
            $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);
            $request = clone $payouts;
            try {
                $output = $payouts->createSynchronous($this->_apiContext);
                $profit->status = 1;
                $profit->save();
                // site profits
                $sitProfits         = new SiteProfit();
                $sitProfits->profit = ($profit->price * (5 / 100));
                $sitProfits->save();
                return redirect()->back()->with(['message' => 'Profits Sent Successfully']);
            } catch (Exception $ex) {
                return redirect()->back()->with(['error' => 'there is some error']);
            }
        }
        return redirect()->back()->with(['error' => 'there is some error']);
    }


}
