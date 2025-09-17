<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        $events = Event::with(['supervisor', 'student'])
            ->whereDate('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->get();

        return view('Page.FrontEnd.Home', compact('events'));
    }
}
