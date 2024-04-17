<?php

namespace App\Http\Controllers\Auth\Forgot;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpVerification;
use App\Models\User;
use App\Models\UserOtp;
use App\Mail\ResetPasswordMail;
use App\Models\Setting;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        $setting = Setting::firstOrFail();
        return view('auth.forgot.forgot', compact('setting'));
    }

    public function showResetForm(Request $request)
    {
        $setting = Setting::firstOrFail();
        return view('auth.forgot.new-password', compact('setting'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'email' => 'required|email|exists:users,email',
            'phone' => 'required|exists:users,phone',
        ]);

        $user = User::where('email', $request->email)
            ->where('phone', $request->phone)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email atau nomor telepon tidak valid.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password Anda berhasil direset. Silakan masuk dengan password baru Anda.');
    }

    public function showForm()
    {
        $setting = Setting::firstOrFail();
        return view('auth.forgot-password', compact('setting'));
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'via' => 'required|in:email,phone',
            'email' => 'required_if:via,email',
            'phone' => 'required_if:via,phone',
        ]);

        $user = null;
        if ($request->via == 'email') {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->via == 'phone') {
            $user = User::where('phone', $request->phone)->first();
        }

        if (!$user) {
            return back()->with('error', 'Email atau nomor telepon tidak terdaftar.');
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiredAt = now()->addMinutes(5);

        DB::beginTransaction();
        try {
            $userOtp = UserOtp::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'otp' => $otp,
                    'expired_at' => $expiredAt,
                    'otp_type' => $request->via == 'email' ? 'email' : 'whatsapp',
                ],
            );

            DB::commit();

            if ($request->via == 'email') {
                Mail::to($user->email)->send(new EmailOtpVerification($userOtp, $user));
            } elseif ($request->via == 'phone') {
                $this->sendOTPviaWhatsApp($user->phone, $otp, $expiredAt->format('H:i'), 'Nama Komunitas Anda');
            }

            return to_route('forgot.otp-verification', $user->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim OTP. Silakan coba lagi.');
        }
    }

    public function formOtp(Request $request, User $user): View
    {
        $setting = Setting::firstOrFail();
        return view('auth.forgot.otp-forgot', compact('user', 'setting'));
    }

    // Proses verifikasi OTP
    public function verifyOTP(Request $request, User $user)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = $request->otp;

        $userOtp = $user->userOtp()
            ->where('otp', $otp)
            ->where('expired_at', '>=', now())
            ->first();

        if (!$userOtp) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        $userOtp->update([
            'isVerified' => true,
        ]);

        return redirect()->route('password.reset', ['token' => $user->email, 'user' => $user->id]);
    }

    // Kirim OTP via WhatsApp (digunakan saat verifikasi nomor telepon)
    // Kirim OTP via WhatsApp
    private function sendOTPviaWhatsApp($phoneNumber, $userOtp, $expiredAt, $communityName)
    {
        // Ambil pengaturan dari database
        $setting = Setting::firstOrFail();
        $endPoint = $setting->endpoint;
        $apiKey = $setting->api_key;
        $sender = $setting->sender;

        // Format pesan WhatsApp dengan menggunakan template yang Anda berikan
        $message = "Halo,\nKami dari $communityName 🚖\n\nMasukkan Kode OTP berikut untuk verifikasi:\n\nKode OTP : $userOtp\n*Expired dalam waktu 5 menit, Jam $expiredAt\n\nCatatan* Jika Anda tidak melakukan pendaftaran apapun, silahkan abaikan pesan ini. Terima kasih🙏";

        // Kirim pesan WhatsApp
        $client = new Client();
        $url = $endPoint;
        try {
            $response = $client->post($url, [
                'json' => [
                    'api_key' => $apiKey,
                    'sender' => $sender,
                    'number' => $phoneNumber,
                    'message' => $message
                ]
            ]);
            return true; // Berhasil mengirim OTP via WhatsApp
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return false; // Gagal mengirim OTP via WhatsApp
        }
    }

    public function indexResetPassword(Request $request, string $token, User $user): View|RedirectResponse
    {
        $userOtp = UserOtp::where('user_id', $user->id)
            ->whereRelation('user', 'email', $token)
            ->where('isVerified', true)
            ->first();

        if (!$userOtp) {
            return to_route('forgot')->with('error', 'Token tidak valid.');
        }
        $setting = Setting::firstOrFail();
        return view('auth.forgot.new-password', compact('token', 'user', 'setting'));
    }

    public function doResetPassword(Request $request, string $token, User $user)
    {
        $userOtp = UserOtp::where('user_id', $user->id)
            ->whereHas('user', function ($query) use ($token) {
                $query->where('email', $token);
            })
            ->where('isVerified', true)
            ->first();

        if (!$userOtp) {
            return back()->withErrors(['password' => 'Token tidak valid.']);
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        if ($user instanceof \App\Models\User) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $this->sendWhatsAppMessage($user);

        return redirect()->route('login')->with('success', 'Password Anda berhasil direset. Silakan masuk dengan password baru Anda.');
    }

    private function sendWhatsAppMessage($user)
    {
        // Pastikan $user memiliki nomor telepon yang valid
        $userPhone = $user->phone;
        if (!$userPhone) {
            return;
        }

        // Ambil setting dari userOtp
        $setting = Setting::first();

        // Pastikan $setting berisi objek Setting yang valid
        if (!$setting) {
            return;
        }

        // Mengirim pesan WhatsApp
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
