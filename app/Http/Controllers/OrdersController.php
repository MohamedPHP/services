<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;
use App\Order;
use App\User;
use App\Paypal;
use App\Payment;
use App\Notification;
use Auth;

class OrdersController extends Controller
{
    /**
    * table fields [`type`, `status`, `user_order`, `service_id`, `user_id`]
    * 0 => the order request has been sent to the order privider
    * 1 => the order request has been seen from the order privider
    * 2 => the order request has been accepted order privider
    * 3 => the order request has been rejected order privider
    * 4 => the order request has been ended
    */
    public function AddOrder($id) {
        $service = Service::find($id);
        if ($service) {
            if (Auth::user()->id != $service->user_id) {
                $orderedBefore = Order::where('user_order', Auth::user()->id)->whereIn('status', [0, 1, 2, 3])->where('service_id', $service->id)->count();
                if ($orderedBefore == 0) {
                    $profits = Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price');
                    $paymentCost = Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price');
                    $usermony = Paypal::where('user_id', Auth::user()->id)->sum('price');
                    $userRealMony = ($usermony - $paymentCost) + $profits;
                    if ($userRealMony >= $service->price) {
                        $order = new Order();
                        $order->service_id = $service->id;
                        $order->user_order = Auth::user()->id;
                        $order->user_id = $service->user_id;
                        $order->status = 0;
                        $order->type = 0;
                        $order->save();
                        if ($order) {
                            // `user_id`, `order_id`, `price`, `isfinished`
                            $payment = new Payment();
                            $payment->user_id    = Auth::user()->id;
                            $payment->receiver_id= $order->user_id;
                            $payment->order_id   = $order->id;
                            $payment->price      = $service->price;
                            $payment->isfinished = 0;
                            $payment->save();

                            if ($payment) {
                                // add notification
                                // `notify_id`, `type`, `seen`, `url`, `user_notify_you`, `user_id`
                                $notification = new Notification();
                                $notification->notify_id       = $order->id;
                                $notification->type            = 'ReceiveOrder';
                                $notification->seen            = 0;
                                $notification->url             = '';
                                $notification->user_notify_you = Auth::user()->id;
                                $notification->user_id         = $service->user_id;
                                $notification->save();
                                if ($notification) {
                                    return 'true';
                                }
                                abort(403);
                            }
                            abort(403);
                        }
                        abort(403);
                    }
                    return 'Charge your blance and try again please';
                }
                abort(403);
            }
            abort(403);
        }
        abort(403);
    }

    public function getMyPurchaseOrders() {
        $orders = Order::where('user_order', Auth::user()->id)->with('getServiceOwner', 'service')->orderBy('id', 'DESC')->get();
        return [
            'orders' => $orders,
            'user' => Auth::user(),
        ];
    }

    public function getMyIncomeOrders() {
        $orders = Order::where('user_id', Auth::user()->id)->with('userThatRequestTheService', 'service')->orderBy('id', 'DESC')->get();
        return [
            'orders' => $orders,
            'user' => Auth::user(),
        ];
    }

    public function GetOrderById($id) {
        $order = Order::find($id);
        if ($order) {
            $user_id = User::find($order->user_id); // service owner how receved the order
            $user_order = User::find($order->user_order); // Service requester how created the order
            if ($user_id->id != $order->user_order) {
                if (Auth::user()->id == $user_id->id && $order->status == 0) {
                    $order->status = 1;
                    $order->save();
                }
                $order = Order::where('id', $id)->with('service')->first();
                $number_of_times_purchased = Order::where('service_id', $order->service->id)->whereIn('status', [1, 2, 4])->count();


                /*
                ** table fields [ `notify_id`, `type`, `seen`, `url`, `user_notify_you`, `user_id` ]
                ** @params (notify_id, type, user_id)
                ** MakeNotificationSeen(notify_id, type, user_id);
                */
                MakeNotificationSeen($order->id, 'ReceiveOrder', Auth::user()->id);
                MakeNotificationSeen($order->id, 'CompletedOrder', Auth::user()->id);
                MakeNotificationSeen($order->id, 'AcceptedOrder', Auth::user()->id);
                MakeNotificationSeen($order->id, 'RejectedOrder', Auth::user()->id);
                MakeNotificationSeen($order->id, 'NewComment', Auth::user()->id);


                return [
                    'user_id' => $user_id,
                    'order_user' => $user_order,
                    'AuthUser' => Auth::user(),
                    'order' => $order,
                    'number_of_times_purchased' => $number_of_times_purchased,
                ];
            }
            abort(403);
        }
        abort(403);
    }

    public function ChangeStatus($id, $status) {
        $order = Order::find($id);
        $statusarray = [2, 3];
        if (!in_array($status, $statusarray)) {
            return abort(403);
        }
        if ($order) {
            if (Auth::user()->id == $order->user_id) {
                if ($status == 3) {
                    $payment = Payment::where('order_id', $order->id)->first();
                    $payment->isfinished = 2;
                    $payment->save();
                }
                $order->status = $status;
                $order->save();
                if ($order) {
                    // add notification
                    // `notify_id`, `type`, `seen`, `url`, `user_notify_you`, `user_id`
                    $notification = new Notification();
                    $notification->notify_id       = $order->id;
                    if ($order->status == 2) {
                        $notification->type            = 'AcceptedOrder';
                    }else {
                        $notification->type            = 'RejectedOrder';
                    }
                    $notification->seen            = 0;
                    $notification->url             = '';
                    $notification->user_notify_you = Auth::user()->id;
                    $notification->user_id         = $order->user_order;
                    $notification->save();
                    return ['status' =>$order->status];
                }
                abort(403);
            }
            abort(403);
        }
        abort(403);
    }

    public function finishOrder($id, $status) {
        $order = Order::find($id);
        $statusarray = [4];
        if (!in_array($status, $statusarray)) {
            return abort(403);
        }
        if ($order) {
            if (Auth::user()->id == $order->user_order) {
                if ($order->status = 2) {

                    $payment = Payment::where('order_id', $order->id)->first();
                    $payment->isfinished = 1;
                    $payment->save();

                    $order->status = $status;
                    $order->save();
                    if ($order) {

                        $notification = new Notification();
                        $notification->notify_id       = $order->id;
                        $notification->type            = 'CompletedOrder';
                        $notification->seen            = 0;
                        $notification->url             = '';
                        $notification->user_notify_you = Auth::user()->id;
                        $notification->user_id         = $order->user_id;
                        $notification->save();

                        if ($notification) {
                            return ['status' => $order->status];
                        }
                        abort(403);
                    }
                    abort(403);
                }
                abort(403);
            }
            abort(403);
        }
        abort(403);
    }


}
