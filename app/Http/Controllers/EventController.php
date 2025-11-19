<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\StudentParticipation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * عرض جميع الأحداث الخاصة بالمشرف الحالي
     */
    public function index()
    {

        $events = Event::where('supervisor_id', auth()->user()->supervisor->id)->get();
        // return response()->json($events);
        return view('Page.DashBorad.supervisor.Events.index', compact('events'));
    }
    /**
     * إظهار صفحة إنشاء حدث جديد
     */
    public function create()
    {
        return view('events.create');
    }


    public function show(Event $event)
    {
        // Load participations with related student
        $event->load('participations.student');

        // return response()->json($event);
        return  view('Page.DashBorad.supervisor.Events.show', compact('event'));
    }


    public function updateStatus(Request $request, Event $event)
    {
        $request->validate([
            'points' => 'nullable|integer|min:1|max:100',
        ]);

        // قيمة النقاط الافتراضية إذا لم يرسلها المستخدم
        $points = $request->input('points', 5);

        // تحميل المشاركات مع الطلاب لتجنب تكرار الاستعلامات
        $event->load('participations.student');

        // تحقق أن الحدث يحتوي على مشاركات
        if ($event->participations->count() > 0) {

            foreach ($event->participations as $participation) {

                // تأكد أن المشاركة مرتبطة بطالب
                if ($participation->student && $participation->is_attended) {
                    $participation->student->increment('points', $points);
                }
            }
        }

        // تحديث حالة الحدث
        $event->update([
            'is_complated' => true,
        ]);

        return redirect()->back()->with('success', 'تم منح النقاط لجميع الطلاب المشاركين بنجاح.');
    }


    /**
     * حفظ حدث جديد
     */
    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        // رفع الملف إن وجد
        if ($request->hasFile('attach')) {
            $validated['attach'] = $request->file('attach')->store('events', 'public');
        }
        Event::create([
            ...$validated,
            'supervisor_id' => auth()->user()->supervisor->id,
        ]);

        return redirect()->route('supervisor.events.index')
            ->with('success', 'تم إنشاء الحدث بنجاح ✅');
    }

    /**
     * إظهار صفحة تعديل حدث
     */
    public function edit(Event $event)
    {

        return view('events.edit', compact('event'));
    }

    /**
     * تحديث حدث
     */
    public function update(EventRequest $request, Event $event)
    {
        $validated = $request->validated();

        try {
            if ($request->hasFile('attach')) {
                if ($event->attach && Storage::disk('public')->exists($event->attach)) {
                    Storage::disk('public')->delete($event->attach);
                }
                $validated['attach'] = $request->file('attach')->store('events', 'public');
            }

            $event->update($validated);

            return redirect()->route('supervisor.events.index')
                ->with('success', 'تم تحديث الحدث بنجاح ✨');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['error' => 'حدث خطأ أثناء تحديث الحدث 😢'])
                ->withInput();
        }
    }


    /**
     * حذف حدث
     */
    public function destroy(Event $event)
    {

        $event->delete();

        return redirect()->route('supervisor.events.index')
            ->with('success', 'تم حذف الحدث بنجاح ❌');
    }



    public function participate(Request $request, Event $event)
    {
        $student = Auth::user()->student;

        // Check if the student already participated
        $existing = StudentParticipation::where('student_id', $student->id)
            ->where('event_id', $event->id)
            ->first();
        if ($existing) {
            return back()->with('error', 'You have already participated in this event.');
        }

        // Validate participation input
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        // Create participation
        $participation = StudentParticipation::create([
            'student_id' => $student->id,
            'event_id' => $event->id,
            'description' => $request->description,
            'attendance_status' => 'active', // default status
        ]);

        return back()->with('success', 'You have successfully participated in the event.');
    }

    public function updateAttendance(Request $request, StudentParticipation $participation)
    {
        // Convert checkbox to boolean
        $is_attended = $request->has('is_attended') ? true : false;
        // return response()->json($participation);
        $participation->update([
            'is_attended' => $is_attended,
        ]);

        return back()->with('success', 'تم تحديث حالة الحضور بنجاح.');
    }
}
