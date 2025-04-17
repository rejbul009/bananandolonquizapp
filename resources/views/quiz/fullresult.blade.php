@extends('layouts.app')

@section('content')




<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl text-center font-bold mb-3">{{ $quiz->title }} - Full Result</h2>

        <p class="text-lg text-center mb-6">Your Score: <strong>{{ $score }}</strong></p>

        @foreach($userAnswers as $index => $answer)
            @php
                $question = $answer->question;
                $selectedOption = $answer->option;
                $correctOption = $question->options->firstWhere('is_correct', true);
                $isCorrect = $selectedOption && $selectedOption->id === $correctOption->id;
            @endphp

            <div class="mb-6 p-4 rounded border
                @if($isCorrect)
                    border-green-400 bg-green-50
                @else
                    border-red-400 bg-red-50
                @endif">

                <p class="md:text-lg text-base font-semibold mb-2">
                    {{ $index + 1 }}. {{ $question->question_text }}
                </p>

                <ul class="pl-5">
                    @foreach($question->options as $option)
                        <li class="mb-1 md:text-base text-sm">
                            <span class="
                                @if($option->id === $correctOption->id)
                                    text-green-600 font-semibold
                                @elseif($option->id === $selectedOption?->id)
                                    text-red-600 font-semibold
                                @endif
                            ">
                                @if($option->id === $selectedOption?->id)
                                    @if($isCorrect)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                @endif
                                {{ $option->option_text }}
                                @if($option->id === $correctOption->id && !$isCorrect)
                                    <span class="text-green-600">(Correct Answer)</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>

</div>
    @endsection
