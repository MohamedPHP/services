<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\User;

use App\Paypal;

use App\Payment;

use App\Notification;
use App\SiteProfit;

use App\Profit;

use Auth;

class UserController extends Controller
{
    public function getAuthUser() {
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

    public function getAllWithdrawbalance() {
        if (Auth::check()) {
            $sumWating = Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') > 0 ? Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') : 0;
            $sumDone = Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') > 0 ? Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') : 0;
            return [
                'user' => Auth::user(),
                'profits' => Profit::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get(),
                'sumWating' => $sumWating,
                'sumDone' => $sumDone,
            ];
        }
        abort(403);
    }

    public function getAllBalance() {
        // كل الارباح الي انا كسبتها من بيع الخدمات
        $profits      = Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') > 0 ? Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') : 0;
        // الارباح الي انا بعت طلب اني اخدها
        $gotProfits   = Profit::where('user_id', Auth::user()->id)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->sum('price') : 0;
        // الارباح الي انا بعت طلب و مستني تتوافق
        $waitProfits  = Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') : 0;
        // الارباح الي انا بعت طلب علشان اخدها و اتوافقت
        $doneProfits  = Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') : 0;
        // المدفوعات
        $payments     = Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') : 0;
        // اجمالي عمليات الشحن
        $charges      = Paypal::where('user_id', Auth::user()->id)->sum('price') > 0 ? Paypal::where('user_id', Auth::user()->id)->sum('price') : 0;
        return [
            'user'     => Auth::user(),
            'profits'  => $profits - $gotProfits,
            'waitProfits'  => $waitProfits,
            'doneProfits'  => $doneProfits,
            'payments' => $payments,
            'charges'  => $charges,
        ];
    }

    public function getUserNotifications($length = '') {
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

    public function getNotificationList() {
        return getNotificationObjects();
    }

    public function getProfits(Request $request) {
        $this->validate($request, [
            'profits' => 'numeric|required|min:5'
        ]);
        $gotProfits  = Profit::where('user_id', Auth::user()->id)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->sum('price') : 0;
        $profits  = Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') > 0 ? Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') : 0;
        if ($request->profits <= ($profits - $gotProfits)) {
            // `price`, `status`, `user_id`
            $profit = new Profit();
            $profit->price = $request->profits;
            $profit->status = 0;
            $profit->time = time();
            $profit->user_id = Auth::user()->id;
            $profit->save();
            if ($profit) {
                $waitProfits  = Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') : 0;
                $doneProfits  = Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') > 0  ? Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') : 0;
                return [
                    'status' => 'done',
                    'gotProfit' => $request->profits,
                    'waitProfits'  => $waitProfits,
                    'doneProfits'  => $doneProfits,
                ];
            }
            return 'try again later';
        }
        return "Error You Can't Get Balance More Than You Have";
    }


    public function MarkAllAsSeen() {
        if (Auth::check()) {
            if (Notification::where('user_id', Auth::user()->id)->where('seen', 0)->count() > 0) {
                foreach (Notification::where('user_id', Auth::user()->id)->where('seen', 0)->get() as $notification) {
                    $notification->seen = 1;
                    $notification->save();
                }
                return redirect('/#!/AllNotifications');
            }
            return redirect('/#!/AllNotifications');
        }
        return redirect('/');
    }


}
