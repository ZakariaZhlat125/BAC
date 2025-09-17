<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboradController extends Controller
{
    public function show()
    {
        return view('Page.DashBorad.User.DashBrad');
    }


    public function getMyData()
    {
        $user = Auth::user();
        return  response()->json($user);
    }
}
