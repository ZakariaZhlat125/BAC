<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class SpecializationController extends Controller
{
    public function getSpecializationPage(Request $request)
    {
        // Get from query string: ?specialization=...
        $specialization = $request->query('specialization');

        // Find specialization by title or id
        $specializationModel = Specialization::where('title', $specialization)
            ->orWhere('id', $specialization)
            ->firstOrFail();
        // $events = Event::with(['courses' => function ($query) use ($specializationModel) {
        //     $query->where('specialization_id', $specializationModel->id);
        // }])->get();

        $events = Event::with(['supervisor', 'student'])
            ->whereDate('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->get();
        // Load years with courses that belong to this specialization
        $years = Year::with(['courses' => function ($query) use ($specializationModel) {
            $query->where('specialization_id', $specializationModel->id);
        }])->get();
        $countStudents = Student::where('is_upgraded', true)->count();
        $countEvents = Event::whereDate('event_date', '>=', Carbon::today())->count();
        $topStudent = $specializationModel->students()->with('user')
            ->orderBy('points', 'desc')
            ->take(3)
            ->get();
        // return response()->json($topStudent);
        return view('Page.FrontEnd.specialization.show', [
            'specialization' => $specializationModel,
            'years' => $years,
            'countStudents' => $countStudents,
            'countEvents' =>  $countEvents,
            "topStudent" => $topStudent,
            'events' => $events
        ]);
    }
}
