<?php

namespace App\Http\Controllers\Admin\UserApproved;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApprovedUserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'process')->get();
        return view('admin.user-approved.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = 'active';
        $user->role = 'member';
        $user->save();

        $setting = Setting::firstOrFail();
        $this->sendWhatsAppMessage($setting, $request, $id);

        return redirect()->back()->with('success', 'User Approved Successfully');
    }

    private function sendWhatsAppMessage($setting, Request $request, $id)
    {
        // Mendapatkan pengguna (user) berdasarkan ID pengguna (user_id) dalam dokumen
        $user = User::find($id);

        // Nomor telepon pengguna
        $userPhone = $user->phone;

        // Mengirim pesan WhatsApp
        $client = new Client();
        $response = $client->post($setting->endpoint, [
            'form_params' => [
                'api_key' => $setting->api_key,
                'sender' => $setting->sender,
                'number' => $userPhone,
                'message' =>
                "Halo, *$user->name*!\n" .
                    "Kami dari *$setting->community_name* ingin memberitahukan bahwa akun Anda telah diterima sebagai *$user->role*. Silakan login ke aplikasi kami untuk memulai.\n" .
                    "Terima kasih."
            ]
        ]);

        // Mengembalikan respons dari server
        return $response->getBody()->getContents();
    }
}
