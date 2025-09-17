<?php

namespace App\Http\Controllers;

use App\Models\ContentReport;
use Illuminate\Http\Request;

class ContentReportController extends Controller
{
    public function storeReport(Request $request)
    {
        // ✅ التحقق من المدخلات
        $validated = $request->validate([
            'type'       => 'required|string|max:50',   // مثل (spam, abuse, other)
            'reason'     => 'nullable|string|max:1000',
            'content_id' => 'required|exists:contents,id',
        ]);

        // ✅ إنشاء التقرير
        $report = ContentReport::create([
            'type'       => $validated['type'],
            'reason'     => $validated['reason'] ?? null,
            'content_id' => $validated['content_id'],
        ]);

        // ✅ (اختياري) إشعار الأدمن أو المشرف
        // Notification::send($admins, new NewContentReportNotification($report));

        return back()->with('success', 'تم إرسال البلاغ بنجاح، سيتم مراجعته قريباً.');
    }
}
