<?php

namespace App\Http\Controllers\Member\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserDocumentType;
use App\Models\User;
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
        return redirect()->route('member.dashboard')->with('success', 'Registrasi berhasil.');
    }
}
