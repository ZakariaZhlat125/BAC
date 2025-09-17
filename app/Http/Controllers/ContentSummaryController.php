<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use App\Notifications\ContentSummaryNotification;
use Illuminate\Http\Request;

class ContentSummaryController extends Controller
{
    public function storeSummary(Request $request)
    {
        $validated = $request->validate([
            'type'       => 'required|string|max:50',   // مثل (اقتراح، تعديل، ملاحظات)
            'notes'      => 'nullable|string|max:1000', // ملخص من المشرف
            'content_id' => 'required|exists:contents,id',
        ]);

        $summary = Summary::create([
            'type'         => $validated['type'],
            'notes'        => $validated['notes'] ?? null,
            'content_id'   => $validated['content_id'],
            'supervisor_id' => auth()->user()->supervisor->id,
        ]);
        $student = $summary->content->student->user; // نفترض أن عندك علاقة: Content -> Student -> User
        $student->notify(new ContentSummaryNotification($summary));

        return back()->with('status_message', 'تم إرسال الملخص للطالب لمراجعة المحتوى.');
    }
}
