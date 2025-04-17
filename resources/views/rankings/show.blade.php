@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto my-5 bg-white p-5 rounded-lg shadow-lg">
    <h1 class="md:text-4xl text-2xl font-bold text-gray-800 text-center mb-8">Leader Board</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($rankers->count() > 0)
        <!-- Top Leader (Position 1) -->
        @php $topLeader = $rankers[0]; @endphp
        <div class="bg-amber-50 p-4 rounded-lg text-center mb-6">
            <div class="text-sm font-medium text-amber-600 mb-2">Position: 1</div>

            <img src="{{ $topLeader->user && $topLeader->user->profile_picture ? asset($topLeader->user->profile_picture) : 'https://via.placeholder.com/80' }}"
                class="w-20 h-20 rounded-full border-2 border-amber-400 object-cover mx-auto mb-4"
                alt="Top Leader">
            <div class="md:text-lg font-bold text-gray-800">{{ $topLeader->user->name ?? 'Unknown User' }}</div>
            <div class="md:text-lg text-gray-600">{{ $topLeader->score }}</div>
        </div>

        <!-- Remaining Rankers (Position 2 to 10) -->
        @for ($i = 1; $i < $rankers->count(); $i++)
            @php $result = $rankers[$i]; @endphp
            <div class="bg-gray-50 p-3 rounded-md mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Position: {{ $i + 1 }}</span>
                    <span class="text-xl font-bold text-gray-800">Score: {{ $result->score }}</span>
                </div>
                <div class="flex items-center mt-2">
                    <img src="{{ $result->user && $result->user->profile_picture ? asset($result->user->profile_picture) : 'https://via.placeholder.com/40' }}"
                        class="w-10 h-10 rounded-full mr-3" alt="Profile">
                    <span class="font-semibold text-gray-700">{{ $result->user->name ?? 'Unknown User' }}</span>
                </div>
            </div>
        @endfor
    @else
        <div class="text-center text-gray-600">No rankers found.</div>
    @endif
</div>
@endsection


