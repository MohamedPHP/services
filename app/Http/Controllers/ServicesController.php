<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\View;

use Auth;
use Response;

class ServicesController extends Controller
{


    public function getUserServices($id)
    {
        $user = User::find($id);
        if ($user) {
            $services = Service::where('user_id', $user->id)->where('status', 1)->with('category', 'user', 'views')->get();
            return [
                'user' => $user,
                'services' => $services,
            ];
        }
        return abort(403);
    }

    public function getServiceById($id)
    {
        $service = Service::where('id', $id)->with('category', 'user')->first();
        if ($service->status != 1) {
            if (Auth::guest()) {
                return abort(403);
            }else {
                if (Auth::user()->id != $service->user_id) {
                    return abort(403);
                }
            }
        }
        $mySameCat = Service::where('cat_id', $service->cat_id)->where('status', 1)->where('user_id', $service->user_id)->with('category', 'user', 'views')->limit(6)->get();
        $otherSameCat = Service::where('cat_id', $service->cat_id)->where('status', 1)->where('user_id', '!=', $service->user_id)->with('category', 'user', 'views')->limit(6)->get();
        if ($service && $mySameCat && $mySameCat) {
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
            return [
                'service'      => $service,
                'mySameCat'    => $mySameCat,
                'otherSameCat' => $otherSameCat,
            ];
        }
        return 'error';
    }

    public function MyServices()
    {
        $services = Service::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->with('category', 'user', 'views')->get();
        $purchaseOrders = Order::where('user_order', Auth::user()->id)->count();
        $incomingOrders = Order::where('user_id', Auth::user()->id)->count();
        $approvedCounter = Service::where('user_id', Auth::user()->id)->where('status', 1)->count();
        return [
            'services' => $services,
            'user' => Auth::user(),
            'purchaseOrders' => $purchaseOrders,
            'incomingOrders' => $incomingOrders,
            'approvedCounter' => $approvedCounter,
        ];
    }


    public function store(Request $request)
    {
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


    public function upload($file){
        $extension = $file->getClientOriginalExtension();
        $sha1 = sha1($file->getClientOriginalName());
        $filename = date('Y-m-d-h-i-s')."_".$sha1.".".$extension;
        $path = public_path('images/services');
        $file->move($path, $filename);
        return 'images/services/'.$filename;
    }


}
