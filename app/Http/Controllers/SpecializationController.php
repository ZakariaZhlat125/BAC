<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\Specialization;
use App\Models\Year;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class SpecializationController extends Controller
{
    public function getSpecializationPage(Request $request)
    {
        // Get from query string: ?specialization=...
        $specialization = $request->query('specialization');

        // Find specialization by title or id
        $specializationModel = Specialization::where('title', $specialization)
            ->orWhere('id', $specialization)
            ->firstOrFail();
        // $events = Event::with(['courses' => function ($query) use ($specializationModel) {
        //     $query->where('specialization_id', $specializationModel->id);
        // }])->get();
        // Load years with courses that belong to this specialization
        $years = Year::with(['courses' => function ($query) use ($specializationModel) {
            $query->where('specialization_id', $specializationModel->id);
        }])->get();


        return view('Page.FrontEnd.specialization.show', [
            'specialization' => $specializationModel,
            'years' => $years,
        ]);
    }
}
