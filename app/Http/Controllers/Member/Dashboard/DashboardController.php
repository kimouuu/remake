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

        // Ambil semua dokumen pengguna yang terkait dengan jenis dokumen yang diperlukan
        $requiredDocument = $user->userDocument->filter(function ($document) {
            return $document->types->status === 'required';
        })->isNotEmpty();

        if (!$requiredDocument) {
            return redirect()->back()->with('error', 'Anda belum memiliki dokumen yang diperlukan.');
        } else {
            $user->update(['status' => 'process']);
            return redirect()->route('member.dashboard')->with('success', 'Registrasi berhasil.');
        }
    }
}
