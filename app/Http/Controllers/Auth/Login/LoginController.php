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
        // $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login.login');
    }

    public function handleLogin(HandleLoginRequest $request)
    {
        $credentials = $request->validated();
        $phone = $request->input('phone');
        $password = $request->input('password');
        $remember = $request->has('remember');

        if (Auth::attempt(['phone' => $phone, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with(['success' => 'Anda berhasil login']);

                case 'member':
                    return redirect()->route('member.dashboard')->with(['success' => 'Anda berhasil login']);

                case 'non-member':
                    return redirect()->route('member.dashboard')->with(['success' => 'Anda berhasil login']);

                case 'organizer':
                    return view('organizer.test')->with('success', 'You are logged in as an organizer');
                default:
                    return back()->withErrors(['phone' => 'The provided credentials do not match our records.']);
            }
        }

        return back()->withErrors(['phone' => 'The provided credentials do not match our records.']);
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
