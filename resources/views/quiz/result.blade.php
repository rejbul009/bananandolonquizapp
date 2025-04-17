@extends('layouts.app')

@section('content')
<div class="flex flex-col justify-center items-center bg-gray-100 h-full">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-4 text-green-600">Quiz Completed!</h2>

        <p class="text-lg mb-6">Your Score: <strong class="text-black">{{ $score }}</strong></p>

        <div class="flex flex-col space-y-4">
            <a href="{{ route('quiz.fullresult', $quiz) }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition-all duration-200">
               View Full Result
            </a>

            <a href="{{ route('quiz.ranking', $quiz->id) }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded shadow transition-all duration-200">
               View Rankings
            </a>
        </div>
    </div>
</div>
@endsection
