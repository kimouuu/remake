<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Profile\ProfileUpdateRequest;
use App\Http\Requests\Member\Profile\ProfileUpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrFail();
        $user = auth()->user();
        return view('member.profile.index', compact('user', 'setting'));
    }

    public function edit()
    {
        $user = auth()->user();
        $setting = Setting::firstOrFail();
        return view('member.profile.edit', compact('user', 'setting'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return redirect()->route('member.profiles.index')->with('success', 'Profile updated successfully.');
    }


    public function updatePassword(ProfileUpdatePasswordRequest $request)
    {
        $user = $request->user();

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect()->route('member.profiles.index')->with('success', 'Profile password updated successfully.');
        } else {
            return redirect()->route('member.profiles.index')->with('info', 'No changes detected.');
        }
    }
}
