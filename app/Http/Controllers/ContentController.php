<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Notifications\NewContentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function showPage()
    {
        $contents = Content::with('chapter')
            ->where('status', 'pending')
            ->orWhere('status', 'rejected')
            ->get();
        return view('Page.DashBorad.supervisor.content.Content', compact('contents'));
    }

    public function approvedContent()
    {
        $contents = Content::with('chapter')
            ->where('status', 'approved')
            ->get();


        // return response()->json($contents);
        return view('Page.DashBorad.supervisor.content.Content', compact('contents'));
    }

    public function index()
    {
        $content = Content::with('chapter', 'summary')
            ->where('student_id', Auth::user()->student->id)
            ->get();
        // return response()->json($contents);
        return view('Page.DashBorad.User.Content.index', compact('content'));
    }


    public function approved()
    {
        $content = Content::with('chapter', 'summary')
            ->where('student_id', Auth::user()->student->id)
            ->where('status', 'approved')
            ->get();
        // return response()->json($contents);
        return view('Page.DashBorad.User.Content.approved', compact('content'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'file'        => 'nullable|file|mimes:pdf,docx,pptx,txt|max:20480', // 20MB
                'video'       => 'nullable|file|mimes:mp4,mov,avi,wmv,mkv|max:51200', // 50MB
                'chapter_id'  => 'required|exists:chapters,id',
                'type'        => 'required|in:explain,summary',
            ]);

            $content = DB::transaction(function () use ($request) {
                $filePath = $request->hasFile('file')
                    ? $request->file('file')->store('contents', 'public')
                    : null;

                $videoPath = $request->hasFile('video')
                    ? $request->file('video')->store('videos', 'public')
                    : null;

                $content = Content::create([
                    'title'        => $request->title,
                    'description'  => $request->description,
                    'file'         => $filePath,
                    'video'        => $videoPath,
                    'chapter_id'   => $request->chapter_id,
                    'student_id'   => Auth::user()->student->id,
                    'type'         => $request->type,
                    'status'       => 'pending',
                ]);

                // إشعار المشرف
                $supervisor = $content->chapter->course->supervisor->user ?? null;
                if ($supervisor) {
                    $supervisor->notify(new NewContentNotification($content));
                }

                return $content;
            });

            return back()->with('success', '✅ تمت إضافة المحتوى بنجاح وهو بانتظار موافقة المشرف.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
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
            'points' => 'nullable|integer|min:1|max:100',
        ]);

        $content = Content::findOrFail($id);
        $content->status = $request->status;
        $content->supervisor_id = auth()->user()->supervisor->id ?? null;
        $content->save();

        // ✅ في حال اعتماد المحتوى
        if ($request->status === 'approved' && $content->student) {
            $points = $request->input('points', 5); // إذا لم يدخل المستخدم رقم، القيمة الافتراضية 5
            $content->student->increment('points', $points);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المحتوى بنجاح.');
    }



}
