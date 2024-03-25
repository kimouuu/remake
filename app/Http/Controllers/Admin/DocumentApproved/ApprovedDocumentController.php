<?php

namespace App\Http\Controllers\Admin\DocumentApproved;

use App\Http\Controllers\Controller;
use App\Models\UserDocuments;
use App\Models\UserDocumentType;
use Illuminate\Http\Request;

class ApprovedDocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::where('verified_at', null)->get();
        return view('admin.document-approved.index', compact('docs'));
    }

    public function show($id)
    {
        $doc = UserDocuments::find($id);
        return view('admin.document-approved.show', compact('doc'));
    }

    public function update($id, Request $request)
    {
        $document = UserDocuments::findOrFail($id);
        $document->verified_at = now();
        $document->verified_by = $request->user()->id;
        $document->save();

        return redirect()->back()->with('success', 'Document Approved Successfully');
    }
}
