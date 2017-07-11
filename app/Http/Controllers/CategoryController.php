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

class CategoryController extends Controller
{

    public function CategoryServices($id, $length = '') {

        $category = Category::find($id);
        if (!$category) {
            abort(403);
        }
        // get services
        $services = Service::where('status', 1)
            ->where('cat_id', $category->id)
            ->with('category', 'views')
            ->withCount('votes')
            ->orderBy('id', 'DESC');

        if ($length == '') {
            $services->limit(env('limit'));
        }else {
            $services->offset($length)->limit(env('limit'));
        }
        $services = $services->get();
        if (!$services) {
            abort(403);
        }
        foreach ($services as $key => $value) {
            $sum = Vote::where('service_id', $value->id)->sum('vote'); // count stars that the service took
            if ($sum > 0) {
                $services[$key]['sum'] = $sum;
            }else {
                $services[$key]['sum'] = 0;
            }
        }

        if ($length == '') {
            // get cats
            $cats = Category::orderBy('id', 'DESC')->where('id', '!=', $category->id)->get();

            // get related services
            $ip = $_SERVER['REMOTE_ADDR'];
            if (View::where('ip', $ip)->count() == 0) {
                // most viewed
                $sidebarsection1 = DB::table('services')
                ->join('views', 'services.id', '=', 'views.service_id')
                ->where('services.status', 1)
                ->where('services.cat_id', $category->id)
                // determine the cols that i want
                ->select('services.id', 'services.name', DB::raw('COUNT(views.id) as view_times'))
                ->groupBy('services.id')
                ->orderBy('view_times', 'DESC')
                ->limit(6)
                ->get();
            }else {
                $sidebarsection1 = DB::table('services')
                ->join('views', 'services.id', '=', 'views.service_id')
                ->where('services.status', 1)
                // determine the cols that i want
                ->select('services.id', 'services.name', DB::raw('COUNT(views.id) as view_times'))
                ->groupBy('services.id')
                ->where('services.cat_id', $category->id)
                ->orderBy('view_times', 'DESC')
                ->limit(6)
                ->get();
            }


            // choose for you
            if (Auth::check()) {
                $sidebarsection2 = Service::where('status', 1)
                // determine the cols that i want
                ->select('id', 'name')
                ->where('cat_id', $category->id)
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
                ->where('services.cat_id', $category->id)
                ->select('services.id', 'services.name', DB::raw('COUNT(orders.id) as order_count'))
                ->groupBy('services.id')
                ->orderBy('order_count', 'DESC')
                ->limit(6)
                ->get();


            return [
                'services' => $services,
                'category' => $category,
                'cats'            => $cats,
                'sidebarsection1' => $sidebarsection1,
                'sidebarsection2' => $sidebarsection2,
                'sidebarsection3' => $sidebarsection3,
            ];
        }

        return [
            'services' => $services,
            'category' => $category,
        ];

    }


    public function getAllCategories() {
        $categories = Category::orderBy('id', 'DESC')->withCount('services')->get();
        if ($categories) {
            return [
                'categories' => $categories,
            ];
        }
        abort(403);
    }


}
