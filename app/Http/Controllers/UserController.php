<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showAvailableQuizzes()
{
    $user = auth()->user();
    $quizzes = \App\Models\Quiz::all();
    return view('user.quizzes', compact('quizzes'));
}


public function dashboard()
{
    $quizzes = \App\Models\Quiz::all();  // Get all quizzes
    $user = Auth::user(); // Get the currently logged-in user

    return view('dashboard', compact('user', 'quizzes'));  // Passing both user and quizzes to the view
}

public function updatePicture(Request $request)
{
    $user = auth()->user();

    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pics', 'public');
        $user->profile_picture = 'storage/' . $path;
        $user->save();
    }

    return back();
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('status', 'Password successfully changed.');
}


public function Passwordchnage()
{
    return view('user.change-password');
}}







