<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function showRanking(Request $request, $quizId)
{
    // Fetch the top 10 rankers for the given quiz ID
    $rankers = Quiz::where('id', $quizId)
        ->with(['results' => function ($query) {
            $query->orderBy('score', 'desc')->take(10);
        }, 'results.user'])
        ->first();

    if (!$rankers) {
        return redirect()->back()->with('error', 'Quiz not found.');
    }

    // Pass the rankers to the view
    return view('rankings.show', [
        'rankers' => $rankers->results,
    ]);
}
}
