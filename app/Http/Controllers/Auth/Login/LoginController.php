<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\HandleLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login.login');
    }

    public function handleLogin(HandleLoginRequest $request)
    {
        $credentials = $request->validated();
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return view('admin.test')->with('success', 'You are logged in as an admin');
            } elseif (Auth::user()->role === 'member') {
                return view('member.test')->with('success', 'You are logged in as a member');
            } elseif (Auth::user()->role === 'organizer') {
                return view('organizer.test')->with('success', 'You are logged in as an organizer');
            } else {
                return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
