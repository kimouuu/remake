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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OtpValidationController extends Controller
{
    public function index($userId)
    {
        $setting = Setting::firstOrFail();
        $now = now();
        $dataUserOtp = UserOtp::query()->where('user_id', $userId)->latest()->first();

        return view('auth.register.otp', compact('userId', 'now', 'dataUserOtp', 'setting'));
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
        logger($http);

        if ($http->ok() && $updateUserOtp) {
            if ($updateUserOtp) {
                // Use session message for success
                return back()->with(['success' => "Berhasil mengirim ulang OTP"]);
            }
        } else {
            return back()->with(['error' => "Gagal mengirim ulang OTP, periksa koneksi internet anda dan coba lagi."]);
        }
    }
    public function verification(OtpValidationRequest $request, $userId)
    {
        $now = now();
        $checkOtp = UserOtp::query()->where('user_id', $userId)
            ->where('otp', $request->otp)
            ->first();

        if (!$checkOtp || ($checkOtp && $now->isAfter($checkOtp->expired_at))) {;
            session()->flash('error', "Kode OTP kamu sudah kadaluarsa atau salah, periksa kembali atau coba lagi");
        } elseif ($checkOtp->retry <= 0) {
            session()->flash('error', "Terlalu banyak percobaan, silahkan ulang lagi nanti setelah " . Carbon::parse($checkOtp->expired_at)->locale('id_ID')->diffForHumans());
        } elseif ($checkOtp->isVerified == 1) {
            session()->flash('error', "Kode OTP kamu sudah terverifikasi, silahkan login.");
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
                $this->decrementRetryCount($checkOtp);
                return redirect()->route('register.verificationOtp.update', ['userId' => $userId])->with('success', 'Akun anda berhasil dibuat, silahkan lengkapi data diri anda. Terima kasih.');
            } else {
                return redirect()->route('error', 'Gagal mengirim pesan ke WhatsApp. Silakan coba lagi.');
            }
        }
        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }


    private function decrementRetryCount(UserOtp $otp)
    {
        if ($otp && $otp->retry > 0) {
            $otp->decrement('retry');
        }

        if ($otp->retry <= 0) {
            $otp->update([
                'expired_at' => now()->addDays(1),
            ]);
        }
    }

    public function update($userId)
    {
        $user = User::findOrFail($userId);
        $setting = Setting::firstOrFail();
        return view('auth.register.profile', compact('user', 'setting'));
    }

    public function verified(ProfileUpdateRequest $request, $userId)
    {
        $user = User::findOrFail($userId);

        DB::beginTransaction();
        try {

            $userOtp = UserOtp::updateOrCreate([
                'user_id' => $user->id,
                'otp_type' => 'email',
            ], [
                'user_id' => $user->id,
                'otp' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
                'otp_type' => 'email',
                'expired_at' => now()->addMinutes(5),
                'isVerified' => 0,
            ]);

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

            $user->refresh();
            DB::commit();

            // $user->sendEmailVerificationNotification();
            Mail::to($user->email)->send(new \App\Mail\EmailOtpVerification($userOtp, $user));
            return redirect()->route('register.verificationMailOtp.index', $user->id);


            // return redirect()->route('auth.login')->with('success', 'Profil Anda berhasil diperbarui. Silahkan verifikasi alamat email Anda.');
        } catch (\Throwable $th) {
            Log::error($th);


            DB::rollback();
            return redirect()->back();
        }
    }

    public function indexVerifiedMailOtp($userId)
    {
        $setting = Setting::firstOrFail();
        $userOtp = UserOtp::query()->where('user_id', $userId)->where('otp_type', 'email')->latest()->first();
        return view('auth.register.mail-otp', compact('userId', 'userOtp', 'setting'));
    }

    public function verifyEmail(Request $request, $userId)
    {
        $request->validate([
            'otp' => ['required', 'numeric'],
        ]);

        $user = User::findOrFail($userId);

        $userOtp = UserOtp::query()->where('user_id', $userId)
            ->where('otp', request()->otp)
            ->where('otp_type', 'email')->first();

        if ($userOtp) {
            $userOtp->delete();

            $user->update([
                'email_verified_at' => now(),
                'role' => 'non-member'
            ]);

            return redirect()->route('auth.login')->with('success', 'Email anda berhasil diverifikasi. Silahkan login.');
        } else {
            return redirect()->back()->with('error', 'Otp tidak valid');
        }
    }

    public function resendEmailOtp($userId)
    {
        $user = User::findOrFail($userId);

        DB::beginTransaction();
        try {

            $userOtp = UserOtp::updateOrCreate([
                'user_id' => $user->id,
                'otp_type' => 'email',
            ], [
                'user_id' => $user->id,
                'otp' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
                'otp_type' => 'email',
                'expired_at' => now()->addMinutes(5),
                'isVerified' => 0,
            ]);

            $user->refresh();
            DB::commit();

            // $user->sendEmailVerificationNotification();
            Mail::to($user->email)->send(new \App\Mail\EmailOtpVerification($userOtp, $user));
            return redirect()->back()->with('success', 'Berhasil mengirim ulang OTP ke email anda.');
        } catch (\Throwable $th) {
            Log::error($th);


            DB::rollback();
            return redirect()->back();
        }
    }
}
