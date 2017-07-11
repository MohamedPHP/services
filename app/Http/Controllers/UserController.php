<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\User;

use Auth;

class UserController extends Controller
{
    public function getAuthUser()
    {
        if (Auth::check()) {
            return [
                'user' => Auth::user(),
            ];
        }
        abort(403);
    }
}
