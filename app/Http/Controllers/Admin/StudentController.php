<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('student') // only users with role student
            ->with('student')             // eager load relation Student
            ->latest()
            ->paginate(10);

        return view('Page.DashBorad.Admin.students.index', compact('students'));
    }


    public function destroy($id)
    {
        $user = User::with('student')->findOrFail($id);
        $user->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
