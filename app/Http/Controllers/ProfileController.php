<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Specialization;
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
        $user = $request->user();

        // إذا كان طالب
        if ($user->relationLoaded('student') || $user->student) {
            $user->load('student');
        }

        // إذا كان مشرف
        if ($user->relationLoaded('supervisor') || $user->supervisor) {
            $user->load('supervisor');
        }


        // return response()->json($specializations);

        // لو صفحة بليد
        return view('profile.edit', [
            'user' => $user,
            'specializations' => $specializations,
            'years' => $years
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        $user = $request->user();
        // 1. تحديث بيانات المستخدم الأساسية
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 2. تحديث بيانات الطالب إذا كان طالب
        if ($user->hasRole('student')) {
            $user->student()->update([
                'major' => $request->input('major'),
                'year' => $request->input('year'),
                'bio' => $request->input('bio'),
                'specialization_id' => $request->input('specialization_id'),
            ]);
        }

        // 3. تحديث بيانات المشرف إذا كان مشرف
        if ($user->hasRole('supervisor')) {
            $user->supervisor()->update([
                'specialization_id' => $request->input('specialization_id'),
                // 'department_id' => $request->input('department_id'),
            ]);
        }

        return Redirect::route('profile.show')->with('status', 'profile-updated');
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
