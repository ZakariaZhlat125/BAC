<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'feedback'   => 'nullable|string|max:1000',
            'content_id' => 'required|exists:contents,id',
        ]);

        $evaluation = Evaluation::updateOrCreate(
            ['user_id' => Auth::id(), 'content_id' => $request->content_id],
            [
                'rating'   => $request->rating,
                'feedback' => $request->feedback
            ]
        );

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation
        ]);
    }



    public function getEvaluations($contentId)
{
    // التقييمات لكل المستخدمين
    $evaluations = Evaluation::where('content_id', $contentId)->with('user')->get();

    // متوسط التقييم
    $average = round($evaluations->avg('rating'), 1); // 1 decimal

    // تقييم المستخدم الحالي
    $userEvaluation = $evaluations->where('user_id', Auth::id())->first();

    return response()->json([
        'average_rating' => $average,
        'user_rating'    => $userEvaluation ? $userEvaluation->rating : null,
        'evaluations'    => $evaluations
    ]);
}
}
