<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ProfileUpdatePasswordRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use App\Models\Setting;
use GuzzleHttp\Client;
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

            $this->sendWhatsAppMessage($user);
            return redirect()->route('admin.profiles.index')->with('success', 'Profile password updated successfully.');
        } else {
            return redirect()->route('admin.profiles.index')->with('info', 'No changes detected.');
        }
    }

    private function sendWhatsAppMessage($user)
    {
        $userPhone = $user->phone;
        if (!$userPhone) {
            return;
        }
        $setting = Setting::first();

        if (!$setting) {
            return;
        }
        $client = new Client();
        $response = $client->post($setting->endpoint, [
            'form_params' => [
                'api_key' => $setting->api_key,
                'sender' => $setting->sender,
                'number' => $userPhone,
                'message' => "Hallo $user->name\n" . "Kami dari $setting->community_name\n" . "Password Anda berhasil direset. Silakan masuk dengan password baru Anda."
            ]
        ]);

        // Mengembalikan respons dari server
        return $response->getBody()->getContents();
    }
}
