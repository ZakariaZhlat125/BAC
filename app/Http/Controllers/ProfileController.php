<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Specialization;
use App\Models\Supervisor;
use App\Models\UpgradeRequest;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $specializations = Specialization::all();
        $years = Year::all();
        $user = Auth::user();
        // تحميل جميع المشرفين المتاحين لاختيارهم
        $supervisors = Supervisor::with('user')->get();

        // return response()->json($supervisors);
        // إذا كان طالب
        if ($user->relationLoaded('student') || $user->student) {
            $user->load(['student', 'student.yearRelation', 'student.specializ', 'student.supervisor.user']);
        }

        // إذا كان مشرف
        if ($user->relationLoaded('supervisor') || $user->supervisor) {
            $user->load('supervisor');
        }

        // تمرير البيانات إلى واجهة المستخدم
        return view('profile.edit', [
            'user' => $user,
            'specializations' => $specializations,
            'years' => $years,
            'supervisors' => $supervisors,
        ]);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // تعبئة الحقول المسموح بها من request
        $user->fill($request->validated());

        // إعادة تعيين حالة التحقق من البريد إذا تم تغييره
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // حفظ التغييرات في جدول users
        $user->save();

        // ================================
        // 🔹 تحديث بيانات الطالب (إن وجد)
        // ================================
        if ($user->hasRole('student') && $user->student) {
            $user->student()->update([
                'major'             => $request->input('major'),
                'year'              => $request->input('year'),
                'bio'               => $request->input('bio'),
                'specialization_id' => $request->input('specialization_id'),
            ]);

            // 🔹 تحديث أو ربط المشرف الأكاديمي
            if ($request->filled('supervisor_id')) {
                $student = $user->student;
                $supervisorId = $request->input('supervisor_id');
                $student->supervisor()->sync([$supervisorId]);
            }
        }

        // ================================
        // 🔹 تحديث بيانات المشرف (إن وجد)
        // ================================
        if ($user->hasRole('supervisor') && $user->supervisor) {
            $user->supervisor()->update([
                'specialization_id' => $request->input('specialization_id'),
            ]);
        }

        // ================================
        // ✅ إعادة التوجيه بنفس الصفحة
        // ================================
        return redirect()
            ->back()
            ->with('status', 'تم تحديث الملف الشخصي بنجاح ✅');
    }




    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
