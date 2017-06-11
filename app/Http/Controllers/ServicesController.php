<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;
use Auth;
use Response;

class ServicesController extends Controller
{


    public function MyServices()
    {
        $services = Service::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->with('category', 'user')->get();
        return Response::json($services);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|min:5',
            'dis'       => 'required|max:500',
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
