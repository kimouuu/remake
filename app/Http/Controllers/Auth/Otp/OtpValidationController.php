<?php

namespace App\Http\Controllers\Auth\Otp;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Setting;
use App\Models\UserOtp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\Otp\OtpValidationRequest;

class OtpValidationController extends Controller
{
    public function index($userId)
    {

        $userId = decrypt($userId);
        $now = now();
        $dataUserOtp = UserOtp::query()->where('user_id', $userId)->latest()->first();
        // dd($dataUserOtp);

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

        $client = new Client();
        $url = $endPoint;

        try {
            $response = $client->post($url, [
                'json' => $parameter
            ]);

            if ($updateUserOtp) {
                // Use session message for success
                return back()->with(['success' => "Berhasil mengirim ulang OTP"]);
            } else {
                // Use session message for error
                return back()->with(['error' => "Silahkan coba lagi setelah beberapa saat"]);
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            // Use session message for exception handling
            return back()->with(['error' => "Gagal mengirim ulang OTP, periksa koneksi internet anda dan coba lagi."]);
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

            // Send message to whatsapp
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

            $client = new Client();
            $url = $endPoint;

            try {
                $response = $client->post($url, [
                    'json' => $parameter
                ]);

                $checkOtp->update([
                    'isVerified' => '1',
                ]);
                $user = User::findOrFail($userId);
                $checkOtp->delete();
                Auth::login($user);
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                return back()->with(['failed' => "Periksa koneksi internet anda dan coba beberapa saat lagi."]);
            }
            return redirect()->route('auth.login')->with(['success' => $checkOtp->user->name . "Berhasil Login"]);
        }
    }
}
