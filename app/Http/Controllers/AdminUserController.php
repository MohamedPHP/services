<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Order;

use App\Service;

use File;

class AdminUserController extends Controller {


    public function index(Request $request, $sort = '') {
        $sortKeys = ['byAdmins', 'ByRegistrationDateDESC', 'ByRegistrationDateASC', 'byNormalUsers', ''];
        if (!in_array($sort, $sortKeys)) {
            return redirect()->back();
        }
        if ($sort == 'byAdmins') {
            $users = User::where('admin', 1)->withCount('services','myOrders','getMyServiceOrder')->paginate(10);
        }
        if ($sort == 'byNormalUsers') {
            $users = User::where('admin', 0)->withCount('services','myOrders','getMyServiceOrder')->paginate(10);
        }
        if ($sort == 'ByRegistrationDateDESC') {
            $users = User::orderBy('created_at', 'DESC')->withCount('services','myOrders','getMyServiceOrder')->paginate(10);
        }
        if ($sort == 'ByRegistrationDateASC') {
            $users = User::orderBy('created_at', 'ASC')->withCount('services','myOrders','getMyServiceOrder')->paginate(10);
        }
        if ($sort == '') {
            if ($request->q != '') {
                $users = User::where('name', 'like', '%'.$request->q.'%')->withCount('services','myOrders','getMyServiceOrder')->orWhere('email', 'like', '%'.$request->q.'%')->paginate(10);
            }else {
                $users = User::withCount('services','myOrders','getMyServiceOrder')->paginate(10);
            }
        }
        return view('admin.users.index', compact('users'));
    }

    public function edit($user_id) {
        $user = User::find($user_id);
        if ($user) {
            $ordersI = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->with('service', 'getServiceOwner', 'userThatRequestTheService')->limit(5)->get();
            $ordersP = Order::where('user_order', $user->id)->orderBy('id', 'DESC')->with('service', 'getServiceOwner', 'userThatRequestTheService')->limit(5)->get();
            $services = Service::where('user_id', $user->id)->orderBy('id', 'DESC')->with('user')->withCount('orders')->limit(5)->get();
            return view('admin.users.edit', compact('user', 'ordersI', 'ordersP', 'services'));
        }
        return redirect()->back();
    }

    public function update(Request $request, $user_id) {
        $user = User::find($user_id);
        if ($user) {
            if (!in_array($request->admin, [0, 1])) {
                return redirect()->back();
            }
            $this->validate($request, [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'image' => 'image|mimes:jpg,png,jpeg|max:10000',
                'admin' => 'numeric',
            ]);
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->admin = $request->admin;
            if ($request->image != '') {
                $image = public_path() . '/' .$user->image;
                if (File::exists($image)) {
                    File::delete($image);
                }
                $user->image  = $this->upload($request['image']);
            }
            $user->save();
            if ($user) {
                return redirect()->back()->with(['message' => 'User Data Successfully Updated']);
            }
        }
        return redirect()->back();
    }

    public function upload($file) {
        $extension = $file->getClientOriginalExtension();
        $sha1 = sha1($file->getClientOriginalName());
        $filename = date('Y-m-d-h-i-s')."_".$sha1.".".$extension;
        $path = public_path('images/users');
        $file->move($path, $filename);
        return 'images/users/'.$filename;
    }

}
