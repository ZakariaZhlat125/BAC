<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\Event;
use App\Models\Student;
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
        $countStudents = Student::where('is_upgraded', true)->count();
        $countEvents = Event::whereDate('event_date', '>=', Carbon::today())->count();

        return view('Page.FrontEnd.Home', compact('events', 'countStudents', 'countEvents'));
    }

    public function speciCources($id)
    {
        $course = Course::with([
            'year',
            'specializ',
            'chapters.contents', // load contents for each chapter
        ])->findOrFail($id);

        // فصل الفصول بناءً على وجود محتوى أو لا
        $chaptersWithContent = $course->chapters->filter(function ($chapter) {
            return $chapter->contents && $chapter->contents->isNotEmpty();
        });

        $chaptersWithoutContent = $course->chapters->filter(function ($chapter) {
            return !$chapter->contents || $chapter->contents->isEmpty();
        });

        return view('Page.FrontEnd.specializationCourrce.index', compact(
            'course',
            'chaptersWithContent',
            'chaptersWithoutContent'
        ));
    }

    public function showChapter($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('Page.FrontEnd.specializationCourrce.show', compact('chapter'));
    }


    public function showVideoContent($id)
    {
        $contents = Content::where('chapter_id', $id)
            ->where('type', 'explain')
            ->whereNotNull('video')
            ->with('student.user') // لو تبغى بيانات الطالب صاحب الفيديو
            ->get();

        return response()->json($contents);
    }

    public function showSummaryContent($id)
    {
        $contents = Content::where('chapter_id', $id)
            ->where('type', 'summary')
            ->with('student.user') // جلب بيانات الطالب
            ->get();

        return response()->json($contents);
    }
}
