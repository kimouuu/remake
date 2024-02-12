<?php

namespace App\Http\Controllers\Auth\Register;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Setting;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\RegisterRequest;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register.register');
    }

    public function register(RegisterRequest $request)
    {
        // $user = User::create($request->validated());
        $setting = Setting::firstOrFail();
        $communityName = $setting->community_name;

        // Generate otp
        $userPhone = $request->phone;
        $userOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiredAt = now()->addMinutes(5);

        DB::transaction(function () use ($request, &$user, &$addUserOtp, $userOtp, $expiredAt) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);

            $addUserOtp = UserOtp::create([
                'user_id' => $user->id,
                'otp' => $userOtp,
                'expired_at' => $expiredAt
            ]);
        });

        $expiredHour = Carbon::parse($addUserOtp->expired_at)->format('H');
        $expiredMinute = Carbon::parse($addUserOtp->expired_at)->format('i');
        $expiredSecond = Carbon::parse($addUserOtp->expired_at)->format('s');

        // Send whatsapp
        $endPoint = $setting->endpoint;
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $parameter = [
            'api_key' => $apiKey,
            'sender' => $sender,
            'number' => $userPhone,
            'message' => "Halo $request->name\nKami dari $communityName 🚖\n\nMasukkan Kode OTP berikut untuk verifikasi:\n\nKode OTP : $userOtp\n*Expired dalam waktu 5 menit, Jam $expiredHour:$expiredMinute:$expiredSecond\n\nCatatan* Jika Akang/Eteh merasa tidak melakukan pendaftaran apapun, silahkan abaikan pesan ini. Terima kasih🙏",
        ];

        $client = new Client();
        $url = $endPoint;
        try {
            $response = $client->post($url, [
                'json' => $parameter
            ]);

            $hashUserId = encrypt($user->id);
            return redirect()->route('register.verificationOtp.index', $hashUserId);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return back()->with(['error' => "Gagal mengirim OTP, periksa koneksi internet anda dan nomor handphone yang dimasukkan lalu coba lagi."]);
        }
    }
}
