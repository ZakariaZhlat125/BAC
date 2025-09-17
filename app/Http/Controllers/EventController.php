<?php

namespace App\Http\Controllers;

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

    /**
     * حفظ حدث جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name'   => 'nullable|string|max:100',
            'event_date'   => 'nullable|date',
            'location'     => 'nullable|string|max:100',
            'attendees'    => 'nullable|string',
            'description'  => 'nullable|string',
            'attach'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // 2MB max
        ]);
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
    public function update(Request $request, Event $event)
    {

        $validated = $request->validate([
            'event_name'   => 'nullable|string|max:100',
            'event_date'   => 'nullable|date',
            'location'     => 'nullable|string|max:100',
            'attendees'    => 'nullable|string',
            'description'  => 'nullable|string',
            'attach'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // 2MB max
        ]);

        // رفع الملف الجديد إذا موجود
        if ($request->hasFile('attach')) {
            // حذف الملف القديم إذا موجود
            if ($event->attach && Storage::disk('public')->exists($event->attach)) {
                Storage::disk('public')->delete($event->attach);
            }
            $validated['attach'] = $request->file('attach')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('supervisor.events.index')
            ->with('success', 'تم تحديث الحدث بنجاح ✨');
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
}
