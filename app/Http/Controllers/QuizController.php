<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use App\Models\UserQuizResult;
use Illuminate\Container\Attributes\Auth;

class QuizController extends Controller
{
    public function start(Quiz $quiz)
    {
        // প্রশ্ন ও অপশন একসাথে লোড
        $quiz->load('questions.options');

        return view('quiz.take', compact('quiz'));
    }




    public function submitAnswer(Request $request, Quiz $quiz)
{
    $userId = auth()->id();
    $answers = $request->input('answers'); // array: question_id => option_id

    foreach ($answers as $questionId => $selectedOptionId) {
        UserAnswer::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id, // ✅ This is the important part
            'question_id' => $questionId,
            'option_id' => $selectedOptionId,
        ]);
    }

    // Calculate score
    $score = UserAnswer::where('user_id', $userId)
        ->where('quiz_id', $quiz->id)
        ->whereHas('option', function ($query) {
            $query->where('is_correct', true);
        })
        ->count();

    // Save or update result
    UserQuizResult::updateOrCreate(
        [
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
        ],
        [
            'score' => $score,
        ]
    );

    return redirect()->route('quiz.result', $quiz);
}



public function showResult($quizId)
{
    $quiz = Quiz::find($quizId);

    $userQuizResult = UserQuizResult::where('user_id', auth()->id())
                                    ->where('quiz_id', $quizId)
                                    ->latest() // এটা রেজাল্টের মধ্যে সর্বশেষটা নেবে
                                    ->first();

    $score = $userQuizResult ? $userQuizResult->score : 0;

    return view('quiz.result', [
        'quiz' => $quiz,
        'score' => $score,
    ]);
}

public function fullresult(Quiz $quiz)
{
    // ডাটাবেজ থেকে স্কোর আনো
    $userQuizResult = UserQuizResult::where('user_id', auth()->id())
                                    ->where('quiz_id', $quiz->id)
                                    ->latest()
                                    ->first();

    $score = $userQuizResult ? $userQuizResult->score : 0;

    // ইউজারের সব উত্তর আনো
    $userAnswers = UserAnswer::with(['question.options', 'option'])
        ->where('user_id', auth()->id())
        ->where('quiz_id', $quiz->id)
        ->get();

    return view('quiz.fullresult', [
        'quiz' => $quiz,
        'score' => $score,
        'userAnswers' => $userAnswers,
    ]);
}
}
