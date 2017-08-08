<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service;
use App\Notification;
use App\Category;
use App\Vote;
use App\User;
use App\SiteProfit;
use App\Order;
use App\Payment;
use DB;
use File;

class AdminController extends Controller
{
    public function index() {
        // laravel moment
        $m = (new \Moment\Moment('@'.time(), 'CET'));
        $timeNow = $m->format('Y-m-d');


        $users = User::count();
        $services = Service::count();
        $allOrders = Order::count();
        $todayOrders = Order::where('created_at', '>', $timeNow.' 00:00:00')
            ->where('created_at', '<', $timeNow.' 23:59:59')
            ->count();
        $siteProfits = SiteProfit::sum('profit');
        $paymentsToday = Payment::where('created_at', '>', $timeNow.' 00:00:00')
            ->where('created_at', '<', $timeNow.' 23:59:59')
            ->count();
        $chartServices = Service::select(DB::raw('COUNT(*) AS counting, month'))
            ->where('year', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();
        $data = [
            'users'         =>  $users,
            'services'      =>  $services,
            'allOrders'     =>  $allOrders,
            'todayOrders'   =>  $todayOrders,
            'siteProfits'   =>  $siteProfits,
            'paymentsToday' =>  $paymentsToday,
            'chartServices' =>  $chartServices,
        ];

        // return $chartServices;

        return view('admin.index', $data);
    }
}
