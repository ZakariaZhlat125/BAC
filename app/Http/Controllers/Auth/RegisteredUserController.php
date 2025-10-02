<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function create(): View
    {
        $specializations = Specialization::all(); // <-- add $

        return view('auth.register.index', [
            'specializations' => $specializations, // pass to view
        ]);
    }

    public function createSupervisor(): View
    {
        $specializations = Specialization::all(); // <-- add $

        return view('auth.register.supervisor', [
            'specializations' => $specializations, // pass to view
        ]);
    }
    public function createStudent(): View
    {
        $specializations = Specialization::all(); // <-- add $

        return view('auth.register.student  ', [
            'specializations' => $specializations, // pass to view
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\S+\s+\S+\s+\S+$/u'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[0-9]{9}@student\.kfu\.edu\.sa$/i',
                'max:255',
                'unique:' . User::class
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'major' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female',
            'year' => 'required|in:1,2,3,4,5,6',
            'bio' => 'nullable|string',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
            ]);

            $user->student()->create([
                'major' => $request->major,
                'year' => $request->year,
                'bio' => $request->bio,
                'specialization_id' => $request->specialization_id,
                'points' => 0,
            ]);

            $user->assignRole('student');
            event(new Registered($user));

            Auth::login($user);

            DB::commit(); // Commit the transaction if everything is fine

            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if anything goes wrong
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء المستخدم: ' . $e->getMessage()]);
        }
    }


    public function storeSupervisor(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\S+\s+\S+\s+\S+$/u',

            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'regex:/^[^@]+@super\.kfu\.edu\.sa$/i',
                'unique:users,email'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => 'required|in:male,female',
            'specialization_id' => 'nullable|exists:specializations,id',
            // 'department_id' => 'required|exists:departments,id',
        ]);

        DB::beginTransaction();

        try {
            // إنشاء المستخدم أولًا
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
            ]);
            // إنشاء Supervisor المرتبط بالمستخدم
            $user->supervisor()->create([
                'specialization_id' => $request->specialization_id,
                // 'department_id' => $request->department_id,
            ]);

            // تعيين الدور
            $user->assignRole('supervisor');

            // تفعيل حدث التسجيل
            event(new Registered($user));

            // تسجيل الدخول مباشرة
            Auth::login($user);

            DB::commit(); // Commit إذا كل شيء تمام

            return redirect()->route('dashboard')->with('success', 'تم إنشاء المشرف بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback إذا حدث أي خطأ
            return back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء إنشاء المستخدم: ' . $e->getMessage()]);
        }
    }
}
