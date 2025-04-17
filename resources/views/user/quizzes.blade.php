@extends('layouts.app')

@section(section: 'content')

<div class="max-w-3xl mx-auto mt-16 p-8 bg-white rounded-2xl">
    <h2 class="text-3xl font-extrabold mb-8 text-gray-900 border-b pb-4">📚 Available Quizzes</h2>

    <div class="it will be middle of the ">
        @forelse($quizzes as $quiz)
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-gray-900">{{ $quiz->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $quiz->questions_count }} Questions</p>
                    </div>
                    <a href="{{ route('quiz.start', $quiz) }}"
                       class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold
                              hover:from-blue-600 hover:to-blue-700 transition-colors shadow-md">
                        Start Quiz
                    </a>
                </div>
            </div>
        @empty
            <div class="text-gray-500 text-center py-6 text-lg">🚫 No quizzes available at the moment.</div>
        @endforelse
    </div>
</div>
</div>
@endsection
