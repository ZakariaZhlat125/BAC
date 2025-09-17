<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    /**
     * عرض جميع الفصول
     */
    public function index()
    {
        $chapters = Chapter::with('course')->latest()->paginate(10);
        return view('chapters.index', compact('chapters'));
    }

    /**
     * عرض فورم إضافة فصل جديد
     */
    public function create()
    {
        $courses = Course::all(); // عشان نربط الفصل بكورس
        return view('chapters.create', compact('courses'));
    }

    /**
     * حفظ فصل جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'course_id'   => 'required|exists:courses,id',
        ]);
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('chapters', 'public');
        }
        Chapter::create($validated);

        return redirect()->route('supervisor.courses.show', $request->course_id)
            ->with('success', 'تمت إضافة الفصل بنجاح ✅');
    }

    /**
     * عرض فصل محدد
     */
    public function show($id)
    {

        $chapter = Chapter::with(['course', 'course.specializ'])->findOrFail($id);
        return view('Page.DashBorad.supervisor.chapter.show', compact('chapter'));
    }

    /**
     * عرض فورم تعديل فصل
     */
    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $courses = Course::all();
        return view('chapters.edit', compact('chapter', 'courses'));
    }

    /**
     * تحديث فصل موجود
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);


        $chapter = Chapter::findOrFail($id);


        // رفع الملف الجديد إذا موجود
        if ($request->hasFile('file')) {
            // حذف الملف القديم إذا موجود
            if ($chapter->file && Storage::disk('public')->exists($chapter->file)) {
                Storage::disk('public')->delete($chapter->file);
            }
            $validated['file'] = $request->file('file')->store('chapters', 'public');
        }
        //  dd('test');
        $chapter->update($validated);

        return redirect()->route('supervisor.courses.show', $chapter->course_id)
            ->with('success', 'تم تحديث الفصل بنجاح ✨');
    }

    /**
     * حذف فصل
     */
    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $courseId = $chapter->course_id; // get the related course ID
        $chapter->delete();

        return redirect()->route('supervisor.courses.show', $courseId)
            ->with('success', 'تم حذف الفصل 🚮');
    }
    public function myChapter($id)
    {

        $chapter = Chapter::with(['course', 'course.specializ', 'contents' => function ($query) {
            $query->where('status', 'approved');
        }])->findOrFail($id);
        return view('Page.DashBorad.User.course.show-chapter', compact('chapter'));
    }

    /**
     * بحث عن الفصول بالعنوان
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $chapters = Chapter::where('title', 'like', "%$keyword%")
            ->with('course')
            ->paginate(10);

        return view('chapters.index', compact('chapters'));
    }
}
