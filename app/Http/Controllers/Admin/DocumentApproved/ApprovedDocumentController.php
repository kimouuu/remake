<?php

namespace App\Http\Controllers\Admin\DocumentApproved;

use App\Http\Controllers\Controller;
use App\Models\UserDocuments;
use App\Models\UserDocumentType;
use App\Models\User;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApprovedDocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::where('verified_by', null)->get();
        return view('admin.document-approved.index', compact('docs'));
    }

    public function show($id)
    {
        $doc = UserDocuments::find($id);
        return view('admin.document-approved.show', compact('doc'));
    }

    public function update($id, Request $request)
    {
        $setting = Setting::firstOrFail();
        $document = UserDocuments::findOrFail($id);
        $document->verified_at = now();
        $document->verified_by = $request->user()->id;
        $document->save();

        $this->sendWhatsAppMessage($setting, $request, $id, true);
        return redirect()->back()->with('success', 'Document Approved Successfully');
    }

    public function reject($id, Request $request)
    {
        $setting = Setting::firstOrFail();
        $document = UserDocuments::findOrFail($id);
        $document->verified_at = null;
        $document->verified_by = $request->user()->id;
        $document->reason = $request->reason;
        $document->save();

        $this->sendWhatsAppMessage($setting, $request, $id, false);

        return redirect()->back()->with('success', 'Document Rejected Successfully');
    }

    private function sendWhatsAppMessage($setting, Request $request, $id, $isApproved)
    {
        // Mendapatkan dokumen berdasarkan ID
        $document = UserDocuments::find($id);

        // Mendapatkan pengguna (user) berdasarkan ID pengguna (user_id) dalam dokumen
        $user = User::findOrFail($document->user_id);

        // Nomor telepon pengguna
        $userPhone = $user->phone;

        // Tentukan pesan berdasarkan apakah dokumen disetujui atau ditolak
        if ($isApproved) {
            $message = "Hallo, *$user->name*!\n" .
                "Kami dari *$setting->community_name*\n" .
                "Dokumen Anda diterima oleh " . $request->user()->name . ". Terima Kasih";
        } else {
            $message = "Hallo, *$user->name*!\n" .
                "Kami dari *$setting->community_name*\n" .
                "Dokumen Anda ditolak oleh " . $request->user()->name . ". Alasan: " . ($document->reason ?? 'Tidak ada alasan') . ". Terima Kasih";
        }

        // Mengirim pesan WhatsApp
        $client = new Client();
        $response = $client->post($setting->endpoint, [
            'form_params' => [
                'api_key' => $setting->api_key,
                'sender' => $setting->sender,
                'number' => $userPhone, // Menggunakan nomor telepon pengguna
                'message' => $message
            ]
        ]);

        // Mengembalikan respons dari server
        return $response->getBody()->getContents();
    }
}
