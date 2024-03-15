<?php

namespace App\Http\Controllers\Admin\DocumentApproved;

use App\Http\Controllers\Controller;
use App\Models\UserDocuments;
use Illuminate\Http\Request;

class ApprovedDocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::whereNull('verified_at')->get();
        return view('admin.document-approved.index', compact('docs'));
    }

    public function update()
    {
        $document = UserDocuments::find(request('id'));
        $document->verified_at = now();
        $document->save();
        return redirect()->back()->with('success', 'Document Approved Successfully');
    }
}
