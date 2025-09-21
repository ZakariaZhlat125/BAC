<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboradController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->hasRole('student')) {
            // تحميل العلاقات مع العد
            $user->load([
                'student',
                'student.contents',
                'student.specializ',
                'student.yearRelation',
            ]);

            // نجيب عدد المحتويات من علاقة student
            $contentsCount = $user->student?->contents->count() ?? 0;

            // نفترض عندك عمود volunteer_hours في جدول students
            $points = $user->student->points ?? 0;

            // حساب النقاط = الساعات / 10
            $volunteerHours  = intval($points / 10);
            // return  response()->json($user);
            return view('Page.DashBorad.User.DashBrad', [
                'user' => $user,
                'volunteerHours' => $volunteerHours,
                'contentsCount'  => $contentsCount,
                'points'         => $points,
            ]);
        }

        if ($user->hasRole('supervisor')) {
            return view('Page.DashBorad.Supervisor.DashBrad', [
                'user' => $user
            ]);
        }

        return abort(403, 'Unauthorized action.');
    }



    public function getMyData()
    {
        $user = Auth::user();
        return  response()->json($user);
    }
}
