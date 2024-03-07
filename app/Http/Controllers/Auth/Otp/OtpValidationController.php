<?php

namespace App\Http\Controllers\Auth\Otp;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Setting;
use App\Models\UserOtp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\Otp\OtpValidationRequest;
use App\Http\Requests\Auth\Register\ProfileUpdateRequest;

class OtpValidationController extends Controller
{
    public function index($userId)
    {

        $now = now();
        $dataUserOtp = UserOtp::query()->where('user_id', $userId)->latest()->first();

        return view('auth.register.otp', compact('userId', 'now', 'dataUserOtp'));
    }

    public function resendOtpCode($userId)
    {
        $userData = User::findOrFail($userId);
        $userName = $userData->name;
        $userPhone = $userData->phone;
        $newOtpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $newExpiredAt = now()->addMinutes(5);
        $dataUserOtp = UserOtp::query()->where('user_id', $userId)->latest()->first();

        $setting = Setting::firstOrFail();
        $communityName = $setting->community_name;
        $updateUserOtp = $dataUserOtp->update([
            'otp' => $newOtpCode,
            'expired_at' => $newExpiredAt,
        ]);

        $expiredHour = Carbon::parse($dataUserOtp->expired_at)->format('H');
        $expiredMinute = Carbon::parse($dataUserOtp->expired_at)->format('i');
        $expiredSecond = Carbon::parse($dataUserOtp->expired_at)->format('s');
        // dd($expiredSecond);

        // Send message to whatsapp
        $endPoint = $setting->endpoint;
        $apiKey = $setting->api_key;
        $sender = $setting->sender;

        $parameter = [
            'api_key' => $apiKey,
            'sender' => $sender,
            'number' => $userPhone,
            'message' => "Halo $userName\nKami dari $communityName 🚖\n\nMasukkan Kode OTP berikut untuk verifikasi:\n\nKode OTP : $dataUserOtp->otp\n*Expired dalam waktu 5 menit, Jam $expiredHour:$expiredMinute:$expiredSecond\n\nCatatan* Jika Akang/Eteh merasa tidak melakukan pendaftaran apapun, silahkan abaikan pesan ini. Terima kasih🙏"
        ];


        $http = Http::post($endPoint, $parameter);

        if ($http->ok()) {
            if ($updateUserOtp) {
                // Use session message for success
                return back()->with(['success' => "Berhasil mengirim ulang OTP"]);
            } else {
                return back()->with(['error' => "Gagal mengirim ulang OTP, periksa koneksi internet anda dan coba lagi."]);
            }
        }
    }
    public function verification(OtpValidationRequest $request, $userId)
    {
        $now = now();
        $checkOtp = UserOtp::query()->where('user_id', $userId)
            ->where('otp', $request->otp)
            ->first();

        if (!$checkOtp) {
            throw ValidationException::withMessages(['otp' => "Kode OTP kamu salah, periksa kembali dan coba lagi"]);
        } elseif ($checkOtp && $now->isAfter($checkOtp->expired_at)) {
            throw ValidationException::withMessages(['otp' => "Kode OTP kamu sudah kadaluarsa"]);
        } else {
            $setting = Setting::firstOrFail();
            $communityName = $setting->community_name;

            // Send message to WhatsApp
            $endPoint = $setting->endpoint;
            $apiKey = $setting->api_key;
            $sender = $setting->sender;

            $userName = $checkOtp->user->name;
            $userPhone = $checkOtp->user->phone;
            $appName = env('APP_NAME');
            $parameter = [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $userPhone,
                'message' => "Halo, $userName\nKami dari $communityName 🚖\n\nSelamat akun anda $userName berhasil dibuat.\nUntuk informasi lebih lanjut silahkan kunjungi $appName"
            ];

            $http = Http::post($endPoint, $parameter);

            if ($http->ok()) {
                $checkOtp->update([
                    'isVerified' => 1,
                ]);

                $user = User::findOrFail($userId);
                $user->update([
                    'phone_verified_at' => now(),
                ]);

                $checkOtp->delete();

                // Redirect to the update profile page
                return redirect()->route('register.verificationOtp.update', ['userId' => $userId])->with('success', 'Akun anda berhasil dibuat, silahkan lengkapi data diri anda. Terima kasih.');
            } else {
                return back()->with(['failed' => "Periksa koneksi internet anda dan coba beberapa saat lagi."]);
            }
        }
    }

    public function update($userId)
    {
        $user = User::findOrFail($userId);

        return view('auth.register.profile', compact('user'));
    }

    public function verified(ProfileUpdateRequest $request, $userId)
    {

        $user = User::findOrFail($userId);
        $user->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_birth' => $request->date_birth,
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
            'status' =>  'waiting',
        ]);

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('auth.login')->with('success', 'Profil Anda berhasil diperbarui. Silahkan verifikasi alamat email Anda.');
        }

        return redirect()->route('auth.login')->with('success', 'Profil Anda berhasil diperbarui. Silahkan verifikasi alamat email Anda.');
    }
}
