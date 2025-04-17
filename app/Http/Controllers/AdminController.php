<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the form to create a quiz and add questions
    public function createQuiz()
    {
        return view('admin.createQuiz');
    }

    // Store the new quiz and questions in the database
    public function storeQuiz(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_option' => 'required|integer',
        ]);

        // Create the quiz
        $quiz = Quiz::create([
            'title' => $request->title,
        ]);

        // Store questions and their options
        foreach ($request->questions as $questionData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
            ]);

            // Store options for each question
            foreach ($questionData['options'] as $key => $optionText) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => ($key == $questionData['correct_option']) ? true : false,
                ]);
            }
        }

        return redirect()->route('admin.quizzes')->with('success', 'Quiz created successfully with questions!');
    }

    // Show the form to edit an existing quiz and its questions
    public function editQuiz($quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        return view('admin.editQuiz', compact('quiz'));
    }

    // Update the quiz and its questions
    public function updateQuiz(Request $request, $quizId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:questions,id', // Added nullable validation for question ID
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_option' => 'required|integer',
        ]);

        // Update the quiz title
        $quiz = Quiz::findOrFail($quizId);
        $quiz->title = $request->title;
        $quiz->save();

        // Loop through all the questions to either update or create them
        foreach ($request->questions as $questionData) {
            // Check if the question already exists (has an ID) or it's a new question
            if (isset($questionData['id'])) {
                // Existing question - update
                $question = Question::findOrFail($questionData['id']);
                $question->question_text = $questionData['question_text'];
                $question->save();

                // Delete old options and store new ones
                $question->options()->delete();
                foreach ($questionData['options'] as $key => $optionText) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct' => ($key == $questionData['correct_option']) ? true : false,
                    ]);
                }
            } else {
                // New question - create
                $newQuestion = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                ]);

                // Store options for the new question
                foreach ($questionData['options'] as $key => $optionText) {
                    Option::create([
                        'question_id' => $newQuestion->id,
                        'option_text' => $optionText,
                        'is_correct' => ($key == $questionData['correct_option']) ? true : false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.quizzes')->with('success', 'Quiz updated successfully!');
    }

    // Show all quizzes
    public function quizzes()
    {
        $quizzes = Quiz::withCount('questions')->get();
        return view('admin.quizzes', compact('quizzes'));
    }

    // Delete a quiz
    public function deleteQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();

        return redirect()->route('admin.quizzes')->with('success', 'Quiz deleted successfully!');
    }

    // Show the form to edit a question
    public function editQuestion($questionId)
    {
        $question = Question::with('options')->findOrFail($questionId);
        return view('admin.editQuestion', compact('question'));
    }

    // Update a question and its options
    public function updateQuestion(Request $request, $questionId)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'correct_option' => 'required|integer',
        ]);

        $question = Question::findOrFail($questionId);
        $question->question_text = $request->question_text;
        $question->save();

        // Delete existing options
        $question->options()->delete();

        // Store new options
        foreach ($request->options as $key => $optionText) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct' => ($key == $request->correct_option) ? true : false,
            ]);
        }

        return redirect()->route('admin.editQuiz', $question->quiz_id)->with('success', 'Question updated successfully!');
    }

    // Delete a question
    public function deleteQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('admin.editQuiz', $quizId)->with('success', 'Question deleted successfully!');
    }

    // Delete an option
    public function deleteOption($optionId)
    {
        $option = Option::findOrFail($optionId);
        $questionId = $option->question_id;
        $option->delete();

        return redirect()->route('admin.editQuestion', $questionId)->with('success', 'Option deleted successfully!');
    }
}
