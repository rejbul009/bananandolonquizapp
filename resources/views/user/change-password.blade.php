@extends('layouts.app')
@section('content')

<div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <form action="{{ route('password.change') }}" method="POST" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-gray-800">Create New Password</h2>
        <p class="text-sm text-gray-500">Your new password must be different from previously used passwords.</p>

        <div>
            <label for="currentpass" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
            <input type="password" name="current_password" id="currentpass" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
        </div>

        <div>
            <label for="newpass" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input type="password" name="new_password" id="newpass" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
        </div>

        <div>
            <label for="confirmpass" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="confirmpass" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                Save
            </button>
            <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:underline">Cancel</a>
        </div>


    </form>
</div>




@endsection
