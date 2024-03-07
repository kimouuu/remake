<?php

namespace App\Http\Controllers\Admin\UserDocumentType;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserDocumentType\DocumentTypeStoreRequest;
use App\Models\UserDocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentType = UserDocumentType::all();
        return view('admin.document-types.index', compact('documentType'));
    }

    public function create()
    {
        return view('admin.document-types.create');
    }

    public function store(DocumentTypeStoreRequest $request)
    {
        UserDocumentType::create($request->validated());
        return redirect()->route('admin.document-types.index');
    }

    public function edit(UserDocumentType $documentType)
    {
        return view('admin.document-types.edit', compact('documentType'));
    }

    public function update(DocumentTypeStoreRequest $request, UserDocumentType $documentType)
    {
        $documentType->update($request->validated());
        return redirect()->route('admin.document-types.index');
    }

    public function destroy(UserDocumentType $documentType)
    {
        $documentType->delete();
        return redirect()->route('admin.document-types.index');
    }
}
