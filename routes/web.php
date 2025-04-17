<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::post('/profile/update-picture', [UserController::class, 'updatePicture'])->name('profile.update.picture');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');
Route::get('/change-password', [UserController::class, 'Passwordchnage'])->name('change.password');







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //quiz

    Route::get('/quizzes', [UserController::class, 'showAvailableQuizzes'])->name('user.quizzes');
    Route::get('/quiz/{quiz}/start', [QuizController::class, 'start'])->name('quiz.start');


// উত্তর সাবমিট

Route::post('/quiz/{quiz}/submit', action: [QuizController::class, 'submitAnswer'])->name('quiz.submit');

Route::get('/quiz/{quiz}/result', [QuizController::class, 'showResult'])->name('quiz.result');

Route::get('/quiz/{quiz}/fullresult', action: [QuizController::class, 'fullresult'])->name('quiz.fullresult');





});



Route::prefix('admin')->middleware('auth')->group(function () {
    // Show all quizzes
    Route::get('/quizzes', [AdminController::class, 'quizzes'])->name('admin.quizzes');

    // Show the form to create a quiz
    Route::get('/create-quiz', [AdminController::class, 'createQuiz'])->name('admin.createQuiz');

    // Store a new quiz
    Route::post('/store-quiz', [AdminController::class, 'storeQuiz'])->name('admin.storeQuiz');

    // Edit a quiz
    Route::get('/edit-quiz/{quizId}', [AdminController::class, 'editQuiz'])->name('admin.editQuiz');

    // ✅ Change to PUT method
    Route::put('/update-quiz/{quizId}', [AdminController::class, 'updateQuiz'])->name('admin.updateQuiz');

    // Delete a quiz
    Route::delete('/delete-quiz/{quizId}', [AdminController::class, 'deleteQuiz'])->name('admin.deleteQuiz');

    // Show the form to edit a question
    Route::get('/edit-question/{questionId}', [AdminController::class, 'editQuestion'])->name('admin.editQuestion');

    // ✅ Change to PUT method
    Route::put('/update-question/{questionId}', [AdminController::class, 'updateQuestion'])->name('admin.updateQuestion');

    // Delete a question
    Route::delete('/delete-question/{questionId}', [AdminController::class, 'deleteQuestion'])->name('admin.deleteQuestion');

    // Delete an option
    Route::delete('/delete-option/{optionId}', [AdminController::class, 'deleteOption'])->name('admin.deleteOption');
});

//rank route


Route::get('/quiz/{quiz}/ranking', [RankController::class, 'showRanking'])->name('quiz.ranking');


require __DIR__.'/auth.php';
