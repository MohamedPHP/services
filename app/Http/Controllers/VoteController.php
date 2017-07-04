<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Service;
use App\User;
use App\Vote;

class VoteController extends Controller
{
    public function AddNewVote(Request $request)
    {
        if (Auth::check()) {
            $array = [1, 2, 3, 4, 5];
            if (in_array($request->value, $array)) {
                $service = Service::find($request->service_id);
                if ($service) {
                    $voteBefore = Vote::where('user_id', Auth::user()->id)->where('service_id', $request->service_id)->count();
                    if ($voteBefore == 0) {
                        $vote = new Vote();
                        $vote->vote = $request->value;
                        $vote->service_id = $request->service_id;
                        $vote->user_id = Auth::user()->id;
                        $vote->save();
                        if ($vote) {
                            return 'voting added';
                        }
                        return 'error';
                    } else {
                        $vote = Vote::where('user_id', Auth::user()->id)->where('service_id', $request->service_id)->first();
                        $vote->vote = $request->value;
                        $vote->save();
                        if ($vote) {
                            return 'voting updated';
                        }
                        return 'error';
                    }
                    return 'error';
                }
                return 'error';
            }
            return 'error';
        }
        return 'not loged in';
    }
}
