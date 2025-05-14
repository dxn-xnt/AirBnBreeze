<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LogInController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_email' => 'required|email',
            'user_password' => 'required|string|min:6'
        ]);

        // Attempt authentication with custom field names
        if (Auth::attempt([
            'user_email' => $credentials['user_email'],
            'password' => $credentials['user_password']
        ], $request->remember)) {
            $request->session()->regenerate();

            // Redirect to intended URL or property creation
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'user_email' => 'Invalid credentials',
        ])->onlyInput('user_email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
