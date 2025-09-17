<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Notifications\NewContentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function showPage()
    {
        $contents = Content::with('chapter')
            ->where('status', 'pending')
            ->get();
        return view('Page.DashBorad.supervisor.content.Content', compact('contents'));
    }


    public function index()
    {
        $content = Content::with('chapter','summary')
            ->where('student_id', Auth::user()->student->id)
            ->where('status', 'approved')
            ->get();
        // return response()->json($contents);
        return view('Page.DashBorad.User.Content.index', compact('content'));
    }

    // إضافة محتوى جديد
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:pdf,docx,pptx,txt|max:2048',
            'chapter_id'  => 'required|exists:chapters,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('contents', 'public');
        }

        $content = Content::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'file'         => $filePath,
            'chapter_id'   => $request->chapter_id,
            'student_id'   => Auth::user()->student->id,
            'status'       => 'pending',
        ]);
        // إرسال إشعار للمشرف
        $supervisor = $content->chapter->course->supervisor->user ?? null; // تأكد من وجود علاقة course -> supervisor
        if ($supervisor) {
            $supervisor->notify(new NewContentNotification($content));
        }

        return back()->with('success', 'تمت إضافة المحتوى بنجاح وهو بانتظار موافقة المشرف.');
    }

    // تحديث محتوى (خاص بالطالب صاحب المحتوى)
    public function update(Request $request, Content $content)
    {
        if ($content->student_id !== Auth::user()->student->id) {
            abort(403, 'غير مسموح لك بتعديل هذا المحتوى');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:pdf,docx,pptx,txt|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('contents', 'public');
            $content->file = $filePath;
        }

        $content->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'تم تحديث المحتوى بنجاح.');
    }

    // حذف محتوى (خاص بالطالب)
    public function destroy(Content $content)
    {
        if ($content->student_id !== Auth::user()->student->id) {
            abort(403, 'غير مسموح لك بحذف هذا المحتوى');
        }

        $content->delete();
        return back()->with('success', 'تم حذف المحتوى بنجاح.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $content = Content::findOrFail($id);
        $content->status = $request->status;
        $content->supervisor_id = auth()->user()->supervisor->id ?? null; // تسجيل المشرف
        $content->save();
        if ($request->status === 'approved' && $content->student) {
            $content->student->increment('points', 5);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المحتوى بنجاح.');
    }
}
