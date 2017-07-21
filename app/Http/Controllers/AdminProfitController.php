<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Profit;

use DateTime;

class AdminProfitController extends Controller
{
    public function index(Request $request, $sort = '')
    {
        // laravel moment
        $m = (new \Moment\Moment('@'.time(), 'CET'));
        $timeNow = $m->subtractDays(env('profitDay'))->format('Y-m-d');

        $sortKeys = ['byDateASC', 'byDateDESC', 'TodaysProfits', 'SearchByDate', 'TodaysProfitsSent', 'byApproved', 'byWating',''];
        if (!in_array($sort, $sortKeys)) {
            return redirect()->back()->with(['error' => 'there is some error']);
        }
        if ($sort == 'byDateASC') {
            $profits = Profit::orderBy('created_at', 'ASC')->with('user')->paginate(10);
        }
        if ($sort == 'byDateDESC') {
            $profits = Profit::orderBy('created_at', 'DESC')->with('user')->paginate(10);
        }
        if ($sort == 'byApproved') {
            $profits = Profit::where('status' ,1)->with('user')->paginate(10);
        }
        if ($sort == 'byWating') {
            $profits = Profit::where('status' ,0)->with('user')->paginate(10);
        }
        if ($sort == 'TodaysProfits') {
            $profits = Profit::where('status', 0)
            ->where('created_at', '>', $timeNow.' 00:00:00')
            ->where('created_at', '<', $timeNow.' 23:59:59')
            ->with('user')->paginate(10);
        }
        if ($sort == 'TodaysProfitsSent') {
            $profits = Profit::where('status',1)->where('created_at', '>', $timeNow.' 00:00:00')
            ->where('created_at', '<', $timeNow.' 23:59:59')
            ->with('user')->paginate(10);
        }
        if ($sort == 'SearchByDate') {
            if (isset($request->q) && $request->q != '') {
                if ($this->validateDate($request->q, 'Y-m-d')) {
                    $profits = Profit::where('created_at', '>', (new \Moment\Moment($request->q, 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 00:00:00')
                            ->where('created_at', '<', (new \Moment\Moment($request->q, 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 23:59:59')
                            ->with('user')->paginate(10);
                }else {
                    return redirect()->back()->with(['error' => 'there is some error']);
                }
            }else {
                return redirect()->back()->with(['error' => 'there is some error']);
            }
        }
        if ($sort == '') {
            $profits = Profit::with('user')->paginate(10);
        }
        return view('admin.profits.index', compact('profits'));
    }

    public function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
