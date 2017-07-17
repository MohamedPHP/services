<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\User;

use App\Paypal;

use App\Payment;

use App\Notification;

use Auth;

class UserController extends Controller
{
    public function getAuthUser()
    {
        if (Auth::check()) {
            return [
                'user' => Auth::user(),
            ];
        }
        abort(403);
    }

    public function getAllCharges() {
        if (Auth::check()) {
            $sum = Paypal::where('user_id', Auth::user()->id)->sum('price') > 0 ? Paypal::where('user_id', Auth::user()->id)->sum('price') : 0;
            return [
                'user' => Auth::user(),
                'charges' => Paypal::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get(),
                'sum' => $sum,
            ];
        }
        abort(403);
    }


    public function getAllpayments() {
        if (Auth::check()) {
            $sum = Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') : 0;
            return [
                'user' => Auth::user(),
                'payments' => Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->orderBy('id', 'DESC')->get(),
                'sum' => $sum,
            ];
        }
        abort(403);
    }

    public function Profits() {
        if (Auth::check()) {
            $sum = Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') > 0 ? Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') : 0;
            return [
                'user' => Auth::user(),
                'profits' => Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->orderBy('id', 'DESC')->get(),
                'sum' => $sum,
            ];
        }
        abort(403);
    }


    public function getAllBalance()
    {
        return [
            'user' => Auth::user(),
            'profits' => Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') > 0 ? Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') : 0,
            'payments' => Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') : 0,
            'charges' => Paypal::where('user_id', Auth::user()->id)->sum('price') > 0 ? Paypal::where('user_id', Auth::user()->id)->sum('price') : 0,
        ];
    }

    public function getUserNotifications($length = '')
    {
        $notifications = Notification::where('user_id', Auth::user()->id)->with('getSender')->orderBy('id', 'DESC');
        if ($length == '') {
            $notifications->limit(env('limit'));
        }else {
            $notifications->offset($length)->limit(env('limit'));
        }
        $notifications = $notifications->get();
        return [
            'notifications' => $notifications,
        ];
    }


    public function getNotificationList()
    {
        return getNotificationObjects();
    }


}
