<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SuperVisorController extends Controller
{

    /**
     * Display a listing of the supervisors.
     */
    public function index()
    {
        $supervisors = User::role('supervisor') // only users with supervisor role
            ->with(['supervisor' ,'supervisor.specializ'  ])               // eager load supervisor relation
            ->latest()
            ->paginate(10);
        // return response()->json($supervisors);
        return view('Page.DashBorad.Admin.supervisor.index', compact('supervisors'));
    }

    /**
     * Remove the specified supervisor and related user.
     */
    public function destroy($id)
    {
        $user = User::with('supervisor')->findOrFail($id);

        if ($user->supervisor) {
            $user->supervisor->delete();
        }

        $user->delete();

        return redirect()
            ->route('admin.supervisors.index')
            ->with('success', 'تم حذف المشرف والمستخدم المرتبط به بنجاح');
    }
}
