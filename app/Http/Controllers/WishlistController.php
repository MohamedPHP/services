<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Service;
use App\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function AddToWishList($service_id) {
        if (Auth::check()) {
            $service = Service::find($service_id);
            if ($service) {
                $serviceAddedBefore = Wishlist::where('service_id', $service->id)->where('user_id', Auth::user()->id)->count();
                // return $service->user_id . ' ' . Auth::user()->id;
                if ($service->user_id != Auth::user()->id) {
                    if ($serviceAddedBefore == 0) {
                        $wishlist = new Wishlist();
                        $wishlist->user_id = Auth::user()->id;
                        $wishlist->service_id = $service->id;
                        $wishlist->own_user = $service->user_id;
                        $wishlist->save();
                        if ($wishlist) {
                            return [
                                'status' => 'AddedToWishList',
                                'sum' => Wishlist::where('user_id', Auth::user()->id)->count(),
                            ];
                        }
                        abort(403);
                    }
                    return [
                        'status' => 'you already added this service to wishlist',
                    ];
                }
                return [
                    'status' => 'this is your service',
                ];
            }
            abort(403);
        }
        return [
            'status' => 'you rrrneed to login',
        ];
    }

    public function GetUserWishList() {
        if (Auth::user()) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('user', 'owner', 'service')->orderBy('id', 'DESC')->get();
            return ['wishlists'=>$wishlist];
        }
    }

    public function DeleteWishList($id) {
        $wishlist = Wishlist::find($id);
        if ($wishlist) {
            if ($wishlist->user_id == Auth::user()->id) {
                $wishlist->delete();
                return [
                    'status'=>'service deleted',
                    'sum' => Wishlist::where('user_id', Auth::user()->id)->count(),
                ];
            }
            abort(403);
        }
        abort(403);
    }
}
