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

class AdminController extends Controller
{
    public function index() {
        return view('admin.index');
    }
}
