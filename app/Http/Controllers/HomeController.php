<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    public function getAllInfo()
    {
        $favCount = getCountWishlistItems(Auth::user()->id);
        $inboxCount = getCountInboxMessages(Auth::user()->id);
        $ordersCount = getCountIncomingOrders(Auth::user()->id);
        $notiCount = getAllNotifications(Auth::user()->id);

        return [
            'favCount'   => $favCount,
            'inboxCount' => $inboxCount,
            'ordersCount'=> $ordersCount,
            'notiCount'  => $notiCount,
        ];


    }

}
