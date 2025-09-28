<?php

namespace App\Http\Controllers;

use App\Models\UpgradeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewUpgradeRequestNotification;
use Illuminate\Support\Facades\Notification;

class UpgradeRequestController extends Controller
{
    public function upgradeProfile(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:1000',
            'attach_file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3,m4a,pptx,pdf|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('attach_file')) {
            $filePath = $request->file('attach_file')->store('upgrade_requests', 'public');
        }

        // الحصول على الطالب الحالي
        $student = Auth::user()->student;

        // تحديث أو إنشاء upgrade request لهذا الطالب
        $upgradeRequest = $student->upgradeRequest()->updateOrCreate(
            [], // hasOne => شرط فارغ
            [
                'status' => 'pending',
                'reason' => $validated['reason'] ?? null,
                'attach_file' => $filePath,
                'supervisor_id' => null,
            ]
        );
        // 🔔 إرسال إشعار لكل المشرفين
        $supervisors = \App\Models\User::role('supervisor')->get(); // باستخدام spatie/laravel-permission
        Notification::send($supervisors, new NewUpgradeRequestNotification($student));

        return back()->with('success', 'تم إرسال طلب الترقية بنجاح، وسيتم مراجعته قريباً.');
    }


    public function index()
    {
        $data = UpgradeRequest::with(['student', 'student.specializ'])->get();
        // return response()->json($data);
        return view('Page.DashBorad.supervisor.upgrade_requests.index', compact('data'));
    }

    public function pending()
    {
        $data = UpgradeRequest::with(['student', 'student.specializ', 'supervisor'])
            ->where('status', 'pending')
            ->get();
        return view('Page.DashBorad.supervisor.upgrade_requests.pending', compact('data'));
    }

    public function myRequest()
    {
        $data = Auth::user()->student->upgradeRequest ?? null;
        return view('Page.DashBorad.User.my-upgrade-request', compact('data'));
    }

    public function updateStatus(Request $request, UpgradeRequest $upgradeRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $upgradeRequest->update([
            'status' => $request->status,
        ]);


        // إذا تمت الموافقة
        if ($request->status === 'approved') {
            // تحديث الطالب ليكون is_upgraded = true
            $student = $upgradeRequest->student;
            if ($student) {
                $student->update(['is_upgraded' => true]);
            }

            // حذف الطلب بعد الموافقة
            $upgradeRequest->delete();

            return back()->with('success', 'تمت الموافقة على طلب الترقية وحذف الطلب.');
        }
        return back()->with('success', 'تم تحديث حالة طلب الترقية بنجاح.');
    }

    public function destroy(UpgradeRequest $upgradeRequest)
    {
        $upgradeRequest->delete();
        return back()->with('success', 'تم حذف طلب الترقية بنجاح.');
    }


    public function checkStatus(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        // إذا الطالب مترقي بالفعل
        if ($student && $student->is_upgraded) {
            return response()->json([
                'has_request' => false,
                'is_upgraded' => true,
            ]);
        }

        // جلب بيانات طلب الترقية إذا موجود
        $requestData = $student?->upgradeRequest ?? null;

        if ($requestData) {
            return response()->json([
                'has_request' => true,
                'status' => $requestData->status,
                'reason' => $requestData->reason,
                'id' => $requestData->id,
                'is_upgraded' => false,
            ]);
        }

        return response()->json([
            'has_request' => false,
            'is_upgraded' => false,
        ]);
    }
}
