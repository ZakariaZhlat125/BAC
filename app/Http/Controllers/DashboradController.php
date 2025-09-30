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
            $user->load([
                'student',
                'student.contents',
                'student.specializ',
                'student.yearRelation',
            ]);

            $contentsCount = $user->student?->contents->count() ?? 0;
            $points = $user->student->points ?? 0;
            $volunteerHours  = intval($points / 10);

            return view('Page.DashBorad.User.DashBrad', [
                'user' => $user,
                'volunteerHours' => $volunteerHours,
                'contentsCount'  => $contentsCount,
                'points'         => $points,
            ]);
        }

        if ($user->hasRole('supervisor')) {
            $user->load([
                'supervisor.specializ',
                'supervisor.contents',
                'supervisor.events',
                'supervisor.upgradeRequests',
            ]);

            // جلب الطلاب من نفس تخصص المشرف
            $studentsQuery = \App\Models\Student::where('specialization_id', $user->supervisor->specialization_id);

            // عدد الطلاب
            $studentsUnderSupervision = $studentsQuery->count();

            // حساب الساعات التطوعية = مجموع النقاط ÷ 10
            $totalPoints = $studentsQuery->sum('points');
            $totalVolunteerHours = intval($totalPoints / 10);

            // باقي الإحصائيات
            $contentsCount   = $user->supervisor->contents->count();
            $pendingContents = $user->supervisor->contents()->where('status', 'pending')->count();
            $eventsPending   = $user->supervisor->events()->count();
            $upgradeRequests = $user->supervisor->upgradeRequests()->where('status', 'pending')->count();

            return view('Page.DashBorad.Supervisor.DashBrad', [
                'user'                => $user,
                'contentsCount'       => $contentsCount,
                'pendingContents'     => $pendingContents,
                'eventsPending'       => $eventsPending,
                'upgradeRequests'     => $upgradeRequests,
                'studentsCount'       => $studentsUnderSupervision,
                'totalVolunteerHours' => $totalVolunteerHours,
            ]);
        }
        if ($user->hasRole('admin')) {

            return view('Page.DashBorad.Admin.DashBorad');
        }

        return abort(403, 'Unauthorized action.');
    }




    public function getMyData()
    {
        $user = Auth::user();
        return  response()->json($user);
    }
}
