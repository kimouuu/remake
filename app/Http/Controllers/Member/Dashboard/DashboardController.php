<?php

namespace App\Http\Controllers\Member\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\UserDocumentType;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $types = UserDocumentType::all();
        return view('member.dashboard.index', compact('types'));
    }

    public function register(Request $request)
    {
        $user = User::find(auth()->id());

        $requiredDocumentTypes = UserDocumentType::where('status', 'required')->pluck('id');
        $requiredDocuments = $user->userDocument()->whereIn('user_document_type_id', $requiredDocumentTypes)->get();
        $requiredDocumentIds = $requiredDocuments->pluck('user_document_type_id')->toArray();
        $missingRequiredDocuments = array_diff($requiredDocumentTypes->toArray(), $requiredDocumentIds);
        if (!empty($missingRequiredDocuments)) {
            return redirect()->back()->with('error', 'Belum semua dokumen yang diperlukan tersedia.');
        }
        $allVerified = $requiredDocuments->every(function ($document) {
            return !is_null($document->verified_at) && !empty($document->input);
        });
        if (!$allVerified) {
            return redirect()->back()->with('error', 'Belum semua dokumen yang diperlukan terverifikasi atau terisi.');
        }

        $user->update(['status' => 'process']);

        // Mengirim pesan WhatsApp kepada pengguna
        $setting = Setting::firstOrFail();
        $this->sendWhatsAppMessageToUser($setting, $user);
        $this->sendWhatsAppMessageToAdmins($setting, $user);

        return redirect()->route('member.dashboard')->with('success', 'Registrasi berhasil.');
    }

    private function sendWhatsAppMessageToUser($setting, $user)
    {
        // Nomor telepon pengguna
        $userPhone = $user->phone;

        // Pesan untuk pengguna
        $message = "Halo, *$user->name*!\n" .
            "Kami dari *$setting->community_name* ingin memberitahukan bahwa akun Anda telah berhasil terdaftar, silahkan tunggu notifikasi selanjutnya!\n" . "Terima kasih.";

        // Mengirim pesan WhatsApp
        $client = new Client();
        $response = $client->post($setting->endpoint, [
            'form_params' => [
                'api_key' => $setting->api_key,
                'sender' => $setting->sender,
                'number' => $userPhone,
                'message' => $message
            ]
        ]);

        // Mengembalikan respons dari server
        return $response->getBody()->getContents();
    }

    private function sendWhatsAppMessageToAdmins($setting, $user)
    {
        // Mendapatkan semua pengguna dengan peran admin
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            // Nomor telepon admin
            $adminPhone = $admin->phone;

            // Pesan untuk admin
            $message = "Halo, Admin!\n" .
                "Pengguna baru telah mendaftar dengan detail berikut:\n" .
                "Nama: *$user->name*\n" .
                "Nomor Handphone: $user->phone\n" .
                "Peran: *$user->role*\n" .
                "Silakan periksa dan proses permintaan mereka.\n" .
                "Terima kasih.";

            // Mengirim pesan WhatsApp
            $client = new Client();
            $response = $client->post($setting->endpoint, [
                'form_params' => [
                    'api_key' => $setting->api_key,
                    'sender' => $setting->sender,
                    'number' => $adminPhone,
                    'message' => $message
                ]
            ]);

            // Mengembalikan respons dari server
            $response->getBody()->getContents();
        }
    }
}
