<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Event;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\UpgradeRequest;
use Carbon\Carbon;
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

            $supervisor = $user->supervisor;

            // 🔹 عدد الطلاب تحت الإشراف
            $studentsUnderSupervision = $supervisor->students()->count();

            // 🔹 النقاط والساعات التطوعية
            $totalPoints = $supervisor->students()->sum('points');
            $totalVolunteerHours = intval($totalPoints / 10);

            // 🔹 المحتويات
            $contentsCount   = $supervisor->contents->count();
            $pendingContents = $supervisor->contents()->where('status', 'pending')->count();

            // 🔹 طلبات الترقية
            $upgradeRequests = UpgradeRequest::where('status', 'pending')
                ->where('supervisor_id', $supervisor->id)
                ->count();

            // 🔹 الفعاليات خلال الأسبوع الحالي (لكل يوم)
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek   = Carbon::now()->endOfWeek();

            $weeklyEvents = Event::selectRaw('DAYNAME(event_date) as day, COUNT(*) as count')
                ->where('supervisor_id', $supervisor->id)
                ->whereBetween('event_date', [$startOfWeek, $endOfWeek])
                ->groupBy('day')
                ->pluck('count', 'day')
                ->toArray();

            // تجهيز البيانات للأيام بالترتيب
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $eventsPerDay = [];
            foreach ($days as $day) {
                $eventsPerDay[] = $weeklyEvents[$day] ?? 0;
            }

            // 🔹 عدد المحتويات في كل تخصص (عن طريق course)
            $specializationStats = Content::join('chapters', 'contents.chapter_id', '=', 'chapters.id')
                ->join('courses', 'chapters.course_id', '=', 'courses.id')
                ->join('specializations', 'courses.specialization_id', '=', 'specializations.id')
                ->where('contents.supervisor_id', $supervisor->id)
                ->selectRaw('specializations.title as specialization_name, COUNT(contents.id) as total')
                ->groupBy('specializations.title')
                ->get();

            return view('Page.DashBorad.Supervisor.DashBrad', [
                'user'                => $user,
                'contentsCount'       => $contentsCount,
                'pendingContents'     => $pendingContents,
                'upgradeRequests'     => $upgradeRequests,
                'studentsCount'       => $studentsUnderSupervision,
                'totalVolunteerHours' => $totalVolunteerHours,
                'specializationStats' => $specializationStats,
                'days'                => json_encode(['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت']),
                'eventsPerDay'        => json_encode($eventsPerDay),
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
        $student = Student::where('user_id', $user->id)->first();

        // Find supervisor(s) that match the student's specialization
        $supervisors = [];
        if ($student && $student->specialization_id) {
            $supervisors = Supervisor::with('user')
                ->where('specialization_id', $student->specialization_id)
                ->get()
                ->map(function ($supervisor) {
                    return [
                        'id' => $supervisor->id,
                        'name' => $supervisor->user->name ?? null,
                        'email' => $supervisor->user->email ?? null,
                    ];
                });
        }

        // Return user data + supervisor info
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender ?? null,
            'specialization_id' => $student->specialization_id ?? null,
            'supervisors' => $supervisors,
        ]);
    }
}
