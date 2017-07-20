<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service;

use App\Order;

use App\Notification;

use App\Category;

use App\Vote;

use App\Payment;

use App\User;

use DB;

use Auth;

use File;

class AdminOrdersController extends Controller
{
    /**
    * table fields [`type`, `status`, `user_order`, `service_id`, `user_id`]
    * 0 => the order request has been sent to the order privider
    * 1 => the order request has been seen from the order privider
    * 2 => the order request has been accepted order privider
    * 3 => the order request has been rejected order privider
    * 4 => the order request has been ended
    */
    public function index(Request $request, $sort = '') {
        $sortKeys = ['byDone', 'byAccepted','byWating','bySeen','byRejected','byAddDateASC','byAddDateDESC', 'UserPOrders', 'UserIOrders',''];
        if (!in_array($sort, $sortKeys)) {
            return redirect()->back();
        }
        if ($sort == 'byDone') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 4)->paginate(10);
        }
        if ($sort == 'UserPOrders') {
            if (isset($request->user_order) && $request->user_order != '') {
                if (User::find($request->user_order)) {
                    $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 4)->where('user_order', $request->user_order)->paginate(10);
                }else {
                    return redirect()->back()->with(['error' => 'there is some error']);
                }
            }else {
                return redirect()->back()->with(['error' => 'there is some error']);
            }
        }
        if ($sort == 'UserIOrders') {
            if (isset($request->user_id) && $request->user_id != '') {
                if (User::find($request->user_id)) {
                    $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 4)->where('user_id', $request->user_id)->paginate(10);
                }else {
                    return redirect()->back()->with(['error' => 'there is some error']);
                }
            }else {
                return redirect()->back()->with(['error' => 'there is some error']);
            }
        }
        if ($sort == 'byAccepted') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 2)->paginate(10);
        }
        if ($sort == 'byWating') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 0)->paginate(10);
        }
        if ($sort == 'bySeen') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 1)->paginate(10);
        }
        if ($sort == 'byRejected') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('status', 3)->paginate(10);
        }
        if ($sort == 'byAddDateASC') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->orderBy('created_at', 'ASC')->paginate(10);
        }
        if ($sort == 'byAddDateDESC') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->orderBy('created_at', 'DESC')->paginate(10);
        }
        if ($sort == '') {
            $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->orderBy('id', 'DESC')->paginate(10);
        }
        return view('admin.orders.index', compact('orders'));
    }

    public function view($id) {
        $order = Order::where('id', $id)->with('userThatRequestTheService', 'getServiceOwner', 'comments')->first();
        if ($order) {
            $service = Service::where('id', $order->service_id)->with('user', 'orders')->withCount('orders', 'votes', 'views')->first();
            $sum = Vote::where('service_id', $service->id)->sum('vote');
            $service['sum'] = $sum;
            return view('admin.orders.edit', compact('order', 'service'));
        }
        return redirect()->back()->with(['error' => 'there is some error']);
    }

    public function changeStatus(Request $request) {
        $order = Order::find($request->order_id);
        if ($order) {
            if (in_array($request->status, [0, 1, 2, 3, 4])) {
                if (in_array($request->status, [0, 1, 2])) {
                    $payment = Payment::where('order_id', $order->id)->where('user_id', $request->user_id)->where('receiver_id', $request->receiver_id)->first();
                    $payment->isfinished = 0;
                    $payment->save();
                }
                if (in_array($request->status, [3])) {
                    $payment = Payment::where('order_id', $order->id)->where('user_id', $request->user_id)->where('receiver_id', $request->receiver_id)->first();
                    $payment->isfinished = 2;
                    $payment->save();
                }
                if (in_array($request->status, [4])) {
                    $payment = Payment::where('order_id', $order->id)->where('user_id', $request->user_id)->where('receiver_id', $request->receiver_id)->first();
                    $payment->isfinished = 1;
                    $payment->save();
                }
                $order->status = $request->status;
                $order->save();
                if ($order) {
                    // For Service Requister
                    $notificationForServiceRequister = new Notification();
                    $notificationForServiceRequister->notify_id       = $order->id;
                    $notificationForServiceRequister->type            = 'ChangeStatusFromAdmin';
                    $notificationForServiceRequister->seen            = 0;
                    $notificationForServiceRequister->url             = '';
                    $notificationForServiceRequister->user_notify_you = Auth::user()->id;
                    $notificationForServiceRequister->user_id         = $order->user_order;
                    $notificationForServiceRequister->save();
                    // For Service Owner
                    $notificationForServiceOwner = new Notification();
                    $notificationForServiceOwner->notify_id           = $order->id;
                    $notificationForServiceOwner->type                = 'ChangeStatusFromAdmin';
                    $notificationForServiceOwner->seen                = 0;
                    $notificationForServiceOwner->url                 = '';
                    $notificationForServiceOwner->user_notify_you     = Auth::user()->id;
                    $notificationForServiceOwner->user_id             = $order->user_id;
                    $notificationForServiceOwner->save();
                }
            }
            return redirect()->back()->with(['error' => 'there is some error']);
        }
        return redirect()->back()->with(['error' => 'there is some error']);
    }

    public function getServiceOrders($service_id, $sort = '') {
        $service = Service::find($service_id);
        if ($service) {
            $sortKeys = ['byDone', 'byAccepted','byWating','bySeen','byRejected','byAddDateASC','byAddDateDESC',''];
            if (!in_array($sort, $sortKeys)) {
                return redirect()->back();
            }
            if ($sort == 'byDone') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->where('status', 4)->paginate(10);
            }
            if ($sort == 'byAccepted') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->where('status', 2)->paginate(10);
            }
            if ($sort == 'byWating') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->where('status', 0)->paginate(10);
            }
            if ($sort == 'bySeen') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->where('status', 1)->paginate(10);
            }
            if ($sort == 'byRejected') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->where('status', 3)->paginate(10);
            }
            if ($sort == 'byAddDateASC') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->orderBy('created_at', 'ASC')->paginate(10);
            }
            if ($sort == 'byAddDateDESC') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->orderBy('created_at', 'DESC')->paginate(10);
            }
            if ($sort == '') {
                $orders = Order::with('service', 'userThatRequestTheService', 'getServiceOwner')->where('service_id', $service->id)->orderBy('id', 'DESC')->paginate(10);
            }
            return view('admin.orders.index', compact('orders'));
        }
    }

}
