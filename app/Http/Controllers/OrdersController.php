<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;
use App\Order;
use App\User;
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
                $orderedBefore = Order::where('user_order', Auth::user()->id)->where('service_id', $service->id)->count();
                if ($orderedBefore == 0) {
                    $order = new Order();
                    $order->service_id = $service->id;
                    $order->user_order = Auth::user()->id;
                    $order->user_id = $service->user_id;
                    $order->status = 0;
                    $order->type = 0;
                    $order->save();
                    if ($order) {
                        return 'true';
                    }
                    return abort(403);
                }
                return abort(403);
            }
            return abort(403);
        }
        return abort(403);
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
            $user_id = User::find($order->user_id);
            $user_order = User::find($order->user_order);
            if ($user_id->id != $order->user_order) {
                $order = Order::where('id', $id)->with('service')->first();
                $number_of_times_purchased = Order::where('service_id', $order->service->id)->whereIn('status', [1, 2, 4])->count();
                return [
                    'user_id' => $user_id,
                    'order_user' => $user_order,
                    'order' => $order,
                    'number_of_times_purchased' => $number_of_times_purchased,
                ];
            }
            return abort(403);
        }
        return abort(403);
    }

}
