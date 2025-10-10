<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Year;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $supervisor = Auth::user()->supervisor;
        // عرض جميع الكورسات مع العلاقات
        $courses = Course::with(['year', 'specializ'])
            ->where('specialization_id', $supervisor->specialization_id)
            ->get();

        $years = Year::get();
        $specializations = Specialization::get();
        // return response()->json($courses );
        return view('Page.DashBorad.supervisor.course.index', compact('courses', 'years', 'specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // جلب البيانات المطلوبة للنماذج (سنوات + تخصصات + طلاب)
        $years = Year::all();
        $specializations = Specialization::all();
        $students = Student::all();

        return view('courses.create', compact('years', 'specializations', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // 🔹 التحقق من صحة المدخلات
            $validated = $request->validate([
                'title' => 'required|string|max:100',
                'description' => 'nullable|string',
                'semester' => 'nullable|string|max:50',
                'year_id' => 'nullable|exists:years,id',
                'difficulty' => 'nullable|integer|min:1|max:10',
                'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'student_id' => 'nullable|exists:students,id',
            ]);
            // 🔹 جلب بيانات المشرف الحالي
            $supervisor = auth()->user()->supervisor ?? null;
            if (!$supervisor) {
                return back()->with('error', 'لم يتم العثور على بيانات المشرف.')->withInput();
            }

            $supervisorId = $supervisor->id;
            $specializationId = $supervisor->specialization_id;

            // 🔹 رفع الصورة
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('courses', 'public');
            }

            // 🔹 حفظ المقرر
            Course::create(array_merge($validated, [
                'supervisor_id' => $supervisorId,
                'specialization_id' => $specializationId,
            ]));

            return redirect()->route('supervisor.courses.index')
                ->with('success', '✅ تم إضافة المقرر بنجاح.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 🔹 إرجاع أخطاء التحقق بصيغة JSON
            return response()->json([
                'status' => 'validation_error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            // 🔹 معالجة الأخطاء
            return back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $th->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::with(['year', 'specializ', 'chapters'])->findOrFail($id);
        // return response()->json($course);
        return view('Page.DashBorad.supervisor.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $years = Year::all();
        $specializations = Specialization::all();
        $students = Student::all();

        return view('courses.edit', compact('course', 'years', 'specializations', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'semester' => 'nullable|string|max:50',
            'year_id' => 'nullable|exists:years,id',
            'difficulty' => 'nullable|integer|min:1|max:10',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            // 'specialization_id' => 'nullable|exists:specializations,id',
            'student_id' => 'nullable|exists:students,id',
        ]);
        $course = Course::findOrFail($id);
        // رفع الملف الجديد إذا موجود
        if ($request->hasFile('image')) {
            // حذف الملف القديم إذا موجود
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }
            $validated['image'] = $request->file('image')->store('cources', 'public');
        }

        $course->update($validated);

        return redirect()->route('supervisor.courses.index')->with('success', 'تم تحديث المقرر بنجاح ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('supervisor.courses.index')->with('success', 'تم حذف المقرر 🗑️');
    }


    public function getMyCources()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return response()->json(['message' => 'الطالب غير موجود'], 404);
        }
        $courses = Course::with(['year', 'specializ'])
            // ->where('year_id', $student->year)
            ->where('specialization_id', $student->specialization_id)
            ->get();

        return view('Page.DashBorad.User.course.index', compact('courses'));
    }


    public function showCourceById($id)
    {
        $course = Course::with(['year', 'specializ', 'chapters'])->findOrFail($id);
        // return response()->json($course);
        return view('Page.DashBorad.User.course.show', compact('course'));
    }
}
