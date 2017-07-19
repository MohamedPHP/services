<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\View;
use App\Order;
use App\Vote;
use App\Category;
use Auth;
use Response;
use DB;

class ServicesController extends Controller
{

    public function getAllServices($length = '') {
        // get services
        $services = Service::where('status', 1)->with('category', 'views')->withCount('votes')->orderBy('id', 'DESC');
        if ($length == '') {
            $services->limit(env('limit'));
        }else {
            $services->offset($length)->limit(env('limit'));
        }
        $services = $services->get();
        foreach ($services as $key => $value) {
            $sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
            if ($sum > 0) {
                $services[$key]['sum'] = $sum;
            }else {
                $services[$key]['sum'] = 0;
            }
        }

        if($length == ''){
            // get cats
            $cats = Category::orderBy('id', 'DESC')->get();

            // get related services
            $ip = $_SERVER['REMOTE_ADDR'];
            if (View::where('ip', $ip)->count() == 0) {
                // most viewed
                $sidebarsection1 = DB::table('services')
                ->join('views', 'services.id', '=', 'views.service_id')
                ->where('services.status', 1)
                // determine the cols that i want
                ->select('services.id', 'services.name', DB::raw('COUNT(views.id) as view_times'))
                ->groupBy('services.id')
                ->orderBy('view_times', 'DESC')
                ->limit(6)
                ->get();
            }else {
                $catView = DB::table('views')->join('services', 'services.id', '=', 'views.service_id')
                ->where('ip', $ip)
                ->lists('services.cat_id');
                // remove duplicate elements from an array
                $catViewIds = array_unique($catView);

                $sidebarsection1 = DB::table('services')
                ->join('views', 'services.id', '=', 'views.service_id')
                ->where('services.status', 1)
                // determine the cols that i want
                ->select('services.id', 'services.name', DB::raw('COUNT(views.id) as view_times'))
                ->groupBy('services.id')
                ->whereIn('services.cat_id', $catViewIds)
                ->orderBy('view_times', 'DESC')
                ->limit(6)
                ->get();
            }


            // choose for you
            if (Auth::check()) {
                $orderCat = DB::table('orders')->join('services', 'services.id', '=', 'orders.service_id')
                ->where('user_order', Auth::user()->id)
                ->lists('services.cat_id');
                // remove duplicate elements from an array
                $orderCat = array_unique($orderCat);
                $sidebarsection2 = Service::where('status', 1)
                // determine the cols that i want
                ->select('id', 'name')
                ->whereIn('cat_id', $orderCat)
                ->inRandomOrder()
                ->limit(6)
                ->get();

            }else {
                $sidebarsection2 = [];
            }


            // best selling
            $sidebarsection3 = DB::table('services')
                ->join('orders', 'services.id', '=', 'orders.service_id')
                ->where('services.status', 1)
                ->select('services.id', 'services.name', DB::raw('COUNT(orders.id) as order_count'))
                ->groupBy('services.id')
                ->orderBy('order_count', 'DESC')
                ->limit(6)
                ->get();


            return [
                'services'        => $services,
                'cats'            => $cats,
                'sidebarsection1' => $sidebarsection1,
                'sidebarsection2' => $sidebarsection2,
                'sidebarsection3' => $sidebarsection3,
            ];


        }

        return [
            'services'        => $services,
        ];



    }

    public function getUserServices($id, $length = '') {
        $user = User::find($id);
        if ($user) {
            $services = Service::where('user_id', $user->id)->where('status', 1)->with('category', 'user', 'views')->withCount('votes');
            if ($length == '') {
                $services->limit(env('limit'));
            }else {
                $services->offset($length)->limit(env('limit'));
            }
            $services = $services->get();
            foreach ($services as $key => $value) {
                $sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
                if ($sum > 0) {
                    $services[$key]['sum'] = $sum;
                }else {
                    $services[$key]['sum'] = 0;
                }
            }
            return [
                'user' => $user,
                'services' => $services,
            ];
        }
        abort(403);
    }

    public function getServiceById($id) {
        $service = Service::where('id', $id)->with('category', 'user')->withCount('votes')->first();
        if ($service) {

            /*
            ** table fields [ `notify_id`, `type`, `seen`, `url`, `user_notify_you`, `user_id` ]
            ** @params (notify_id, type, user_id)
            ** MakeNotificationSeen(notify_id, type, user_id);
            */
            MakeNotificationSeen($service->id, 'AcceptService', Auth::user()->id);
            MakeNotificationSeen($service->id, 'RejectedService', Auth::user()->id);

            // sum votes
            $sum = Vote::where('service_id', $service->id)->sum('vote'); // count stars that the service took
            if ($sum > 0) {
                $sum = Vote::where('service_id', $service->id)->sum('vote'); // count stars that the service took
            }else {
                $sum = 0;
            }

            if ($service->status != 1) {
                if (Auth::guest()) {
                    abort(403);
                }else {
                    if (Auth::user()->id != $service->user_id) {
                        abort(403);
                    }
                }
            }

            // to auto select the stars
            if (Auth::check()) {
                $userVote = Vote::where('service_id', $service->id)->where('user_id', Auth::user()->id)->first();
            }else {
                $userVote = null;
            }

            if (!Auth::guest()) {
                $mySameCat = Service::where('cat_id', $service->cat_id)->where('status', 1)->where('user_id', Auth::user()->id)->with('category', 'user', 'views', 'votes')->withCount('votes')->limit(6)->get();
                foreach ($mySameCat as $key => $value) {
                    $mySameCat_sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
                    if ($mySameCat_sum > 0) {
                        $mySameCat[$key]['sum'] = $mySameCat_sum;
                    }else {
                        $mySameCat[$key]['sum'] = 0;
                    }
                }
                $otherSameCat = Service::where('cat_id', $service->cat_id)->where('status', 1)->where('user_id', '!=', Auth::user()->id)->where('id', '!=', $service->id)->with('category', 'user', 'views', 'votes')->withCount('votes')->limit(6)->get();
                foreach ($otherSameCat as $key => $value) {
                    $otherSameCat_sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
                    if ($otherSameCat_sum > 0) {
                        $otherSameCat[$key]['sum'] = $otherSameCat_sum;
                    }else {
                        $otherSameCat[$key]['sum'] = 0;
                    }
                }
            }else {
                $mySameCat = [];
                $otherSameCat = [];
            }


            $mostRatedServices =
                Service::join('votes', 'services.id', '=', 'votes.service_id')
                    ->select('services.id', 'services.name', DB::raw('SUM(votes.vote) as vote_sum'))
                    ->where('services.cat_id', $service->cat_id)
                    ->where('services.status', 1)
                    ->where('services.id', '!=', $service->id)
                    ->groupBy('services.id')
                    ->orderBy('vote_sum', 'DESC')
                    ->limit(5)
                    ->get();

            $mostViewedServices =
                Service::join('views', 'services.id', '=', 'views.service_id')
                    ->select('services.id', 'services.name', DB::raw('COUNT(views.id) as view_times'))
                    ->where('services.cat_id', $service->cat_id)
                    ->where('services.status', 1)
                    ->where('services.id', '!=', $service->id)
                    ->groupBy('services.id')
                    ->orderBy('view_times', 'DESC')
                    ->limit(5)
                    ->get();


            if (View::where('ip', $_SERVER['REMOTE_ADDR'])->where('service_id', $service->id)->count() == 0) {
                // insert view
                $view = new View();
                $view->service_id = $service->id;
                if (Auth::guest()) {
                    $view->user_id = 0;
                }else {
                    $view->user_id = Auth::user()->id;
                }
                $view->ip = $_SERVER['REMOTE_ADDR'];
                $view->save();
            }

            // choose for you
            if (Auth::check()) {
                $orderCat = DB::table('orders')->join('services', 'services.id', '=', 'orders.service_id')
                ->where('user_order', Auth::user()->id)
                ->lists('services.cat_id');
                // remove duplicate elements from an array
                $orderCat = array_unique($orderCat);
                $sidebarsection2 = Service::where('status', 1)
                    // determine the cols that i want
                    ->select('id', 'name')
                    ->whereIn('cat_id', $orderCat)
                    ->inRandomOrder()
                    ->limit(5)
                    ->get();

            }else {
                $sidebarsection2 = [];
            }

            return [
                'service'      => $service,
                'mySameCat'    => $mySameCat,
                'otherSameCat' => $otherSameCat,
                'userVote'     => $userVote,
                'sum'          => $sum,
                'mostRatedServices' => $mostRatedServices,
                'mostViewedServices'=> $mostViewedServices,
                'sidebarsection2'   => $sidebarsection2,
            ];
        }
        return 'error';
    }

    public function MyServices($length = '') {
        $services = Service::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->with('category', 'user', 'views', 'votes')->withCount('votes');
        if ($length == '') {
            $services->limit(env('limit'));
        }else {
            $services->offset($length)->limit(env('limit'));
        }
        $services = $services->get();

        $purchaseOrders = Order::where('user_order', Auth::user()->id)->count();
        $incomingOrders = Order::where('user_id', Auth::user()->id)->count();
        $approvedCounter = Service::where('user_id', Auth::user()->id)->where('status', 1)->count();
        foreach ($services as $key => $value) {
            $sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
            if ($sum > 0) {
                $services[$key]['sum'] = $sum;
            }else {
                $services[$key]['sum'] = 0;
            }
        }
        return [
            'services' => $services,
            'user' => Auth::user(),
            'purchaseOrders' => $purchaseOrders,
            'incomingOrders' => $incomingOrders,
            'approvedCounter' => $approvedCounter,
        ];
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'      => 'required|min:5',
            'dis'       => 'required|max:1500',
            'image'     => 'required|image|mimes:jpg,png,jpeg|max:10000',
            'price'     => 'required|numeric',
            'cat_id'    => 'required|numeric',
        ]);
        $prices = [5, 10, 15, 20, 25, 30, 40, 50];
        if (in_array($request['price'], $prices)) {
            $service = new Service();
            $service->name   = $request['name'];
            $service->dis    = $request['dis'];
            $service->image  = $this->upload($request['image']);
            $service->price  = $request['price'];
            $service->cat_id = $request['cat_id'];
            $service->user_id = Auth::user()->id;
            $service->save();
            if (!$service) {
                return 'error saving the service';
            }
            return 'service added';
        }
        return 'selectrightprice';
    }

    public function upload($file) {
        $extension = $file->getClientOriginalExtension();
        $sha1 = sha1($file->getClientOriginalName());
        $filename = date('Y-m-d-h-i-s')."_".$sha1.".".$extension;
        $path = public_path('images/services');
        $file->move($path, $filename);
        return 'images/services/'.$filename;
    }

}
