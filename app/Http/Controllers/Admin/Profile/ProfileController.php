<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ProfileUpdatePasswordRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $setting = Setting::firstOrFail();
        return view('admin.profile.index', ['user' => $user, 'setting' => $setting]);
    }
    public function edit()
    {
        $user = auth()->user();
        $setting = Setting::firstOrFail();
        return view('admin.profile.edit', ['user' => $user, 'setting' => $setting]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());
        return to_route('admin.profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(ProfileUpdatePasswordRequest $request)
    {
        $user = $request->user();

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect()->route('admin.profiles.index')->with('success', 'Profile password updated successfully.');
        } else {
            return redirect()->route('admin.profiles.index')->with('info', 'No changes detected.');
        }
    }
}
