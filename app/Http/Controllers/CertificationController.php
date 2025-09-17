<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CertificationController extends Controller
{
    // عرض صفحة الشهادات
    public function show()
    {
        $student = Auth::user()->student;
        $certification = Certificate::where('student_id', $student->id)->latest()->first();

        return view('Page.DashBorad.User.certifications.show', compact('student', 'certification'));
    }

    // إصدار شهادة جديدة
    public function issueCertificate(Student $student)
    {
        $student = Auth::user()->student;
        $hours = $student->volunteer_hours;

        if ($hours <= 0) {
            return back()->with('error', 'لا يوجد ساعات تطوع متاحة.');
        }

        $certification = Certificate::create([
            'student_id'        => $student->id,
            'hours'             => $hours,
            'certificate_number' => 'CERT-' . strtoupper(Str::random(8)),
        ]);

        return redirect()->route('user.certifications.show')->with('success', 'تم إصدار الشهادة بنجاح.');
    }

    public function printCertification(Certificate $certification)
    {
        $pdf = Pdf::loadView('Page.DashBorad.User.certifications.certificate', [
            'certification' => $certification,
        ])->setPaper('A4', 'portrait');
        // return  response()->json($certification);
        return $pdf->stream('certificate.pdf');
    }
}
