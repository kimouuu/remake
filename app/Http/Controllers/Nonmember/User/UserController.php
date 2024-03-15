<?php

namespace App\Http\Controllers\Nonmember\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDocuments;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::find(auth()->id());

        // Ambil semua dokumen pengguna yang terkait dengan jenis dokumen yang diperlukan
        $requiredDocument = $user->userDocument->filter(function ($document) {
            return $document->documentType->status === 'required';
        })->isNotEmpty();

        if (!$requiredDocument) {
            return redirect()->back()->with('error', 'Anda belum memiliki dokumen yang diperlukan.');
        } else {
            $user->update(['status' => 'process']);
            return redirect()->route('member.dashboard')->with('success', 'Registrasi berhasil.');
        }
    }
}
