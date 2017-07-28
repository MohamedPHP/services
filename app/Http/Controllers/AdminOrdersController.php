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
