<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service;

use App\Notification;

use App\Category;

use App\Vote;

use DB;

use File;

use Auth;

class AdminServicesController extends Controller
{
    public function index(Request $request, $sort = '') {
        $sortKeys = [
            'byName',
            'byRejected',
            'byAccepted',
            'byWating',
            'byAddDateASC',
            'byAddDateDESC',
            'byPriceHighToLow',
            'byPriceLowToHigh',
            'byRating',
            'byViewes',
            '',
        ];
        if (!in_array($sort, $sortKeys)) {
            return redirect()->back();
        }
        if ($sort == 'byName') {
            $services = Service::orderBy('name', 'ASC')->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byRejected') {
            $services = Service::where('status', 2)->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byAccepted') {
            $services = Service::where('status', 1)->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byWating') {
            $services = Service::where('status', 0)->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byAddDateASC') {
            $services = Service::orderBy('created_at', 'ASC')->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byAddDateDESC') {
            $services = Service::orderBy('created_at', 'DESC')->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byPriceHighToLow') {
            $services = Service::orderBy('price', 'DESC')->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byPriceLowToHigh') {
            $services = Service::orderBy('price', 'ASC')->with('user')->withCount('orders')->paginate(10);
        }
        if ($sort == 'byRating') {
            $services = Service::join('votes', 'services.id', '=', 'votes.service_id')
                ->select('services.*', DB::raw('SUM(votes.vote) as vote_sum'))
                ->groupBy('services.id')
                ->orderBy('vote_sum', 'DESC')->withCount('orders')
                ->paginate(10);
        }
        if ($sort == 'byViewes') {
            $services = Service::join('views', 'services.id', '=', 'views.service_id')
                ->select('services.*', DB::raw('COUNT(views.id) as view_times'))
                ->groupBy('services.id')
                ->orderBy('view_times', 'DESC')->withCount('orders')
                ->paginate(10);
        }
        if ($sort == '') {
            if (isset($request->q) && $request->q != '') {
                $services = Service::orderBy('id', 'DESC')->where('name', 'like', '%'.strip_tags($request->q).'%')->with('user')->withCount('orders')->paginate(10);
            }else {
                $services = Service::orderBy('id', 'DESC')->with('user')->withCount('orders')->paginate(10);
            }
        }

        $servicesCount = count(Service::all());


        return view('admin.services.index', compact('services', 'servicesCount'));
    }

    public function edit($id) {
        $service = Service::where('id', $id)->with('user', 'orders')->withCount('orders', 'votes', 'views')->first();
        $sum = Vote::where('service_id', $service->id)->sum('vote');
        $service['sum'] = $sum;
        $cats = Category::all();
        if ($service) {
            return view('admin.services.edit', compact('service', 'cats'));
        }
        return redirect()->back()->with(['error' => 'there is some error']);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name'      => 'required|min:5',
            'dis'       => 'required|max:1500',
            'image'     => 'image|mimes:jpg,png,jpeg|max:10000',
            'price'     => 'required|numeric',
            'cat_id'    => 'required|numeric',
        ]);
        $prices = [5, 10, 15, 20, 25, 30, 40, 50];
        if (in_array($request['price'], $prices)) {
            $service = Service::find($id);
            if ($service) {
                if (Category::find($request['cat_id'])) {
                    $service->name   = $request['name'];
                    $service->dis    = $request['dis'];
                    if ($request['image'] != '') {
                        $image = public_path() . '/' .$service->image;
                        if (File::exists($image)) {
                            File::delete($image);
                        }
                        $service->image  = $this->upload($request['image']);
                    }
                    $service->cat_id = $request['cat_id'];
                    $service->price  = $request['price'];
                    $service->save();
                    return redirect()->back()->with(['message' => 'Success Proccess Service Updated']);
                }
                return redirect()->back()->with(['error' => 'there is some error']);
            }
            return redirect()->back()->with(['error' => 'there is some error']);
        }
        return redirect()->back()->with(['error' => 'there is some error']);
    }

    public function delete($id) {
        $service = Service::find($id);

        if (!$service) {
            return redirect()->back()->with(['error' => 'there is some error']);
        }

        $image = public_path() . '/' .$service->image;

        if (File::exists($image)) {
            File::delete($image);
        }

        foreach ($service->orders as $order) {
            Notification::where('notify_id', $order->id)->delete();
        }

        $service->delete();

        return redirect()->back()->with(['message' => 'Success Proccess Service Deleted']);
    }

    public function accept($id) {
        $service = Service::find($id);

        if (!$service) {
            return redirect()->back()->with(['error' => 'there is some error']);
        }

        $service->status = 1;

        $service->save();

        if ($service) {
            $notification = new Notification();
            $notification->notify_id       = $service->id;
            $notification->type            = 'AcceptService';
            $notification->seen            = 0;
            $notification->url             = '';
            $notification->user_notify_you = Auth::user()->id;
            $notification->user_id         = $service->user_id;
            $notification->save();
        }

        return redirect()->back()->with(['message' => 'Success Proccess Service Approved']);
    }

    public function reject($id) {
        $service = Service::find($id);

        if (!$service) {
            return redirect()->back()->with(['error' => 'there is some error']);
        }

        $service->status = 2;

        $service->save();
        if ($service) {
            $notification = new Notification();
            $notification->notify_id       = $service->id;
            $notification->type            = 'RejectedService';
            $notification->seen            = 0;
            $notification->url             = '';
            $notification->user_notify_you = Auth::user()->id;
            $notification->user_id         = $service->user_id;
            $notification->save();
        }
        return redirect()->back()->with(['message' => 'Success Proccess Service Rejected']);
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
