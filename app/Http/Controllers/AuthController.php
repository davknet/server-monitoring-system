<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show login form
     public function showLogin()
    {
        return view('auth.login');
    }


    // Handle login
   public function login(LoginRequest $request)
{

// Log::info('Login attempt for email: ' . $request->input('email'));
// Log::info('Login attempt for password: ' . $request->input('password'));
// Log::info('Login attempt with validated data: ' . json_encode($request->validated()));




    if (Auth::attempt($request->validated())) {
        $request->session()->regenerate();

        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials',
    ]);







    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}
