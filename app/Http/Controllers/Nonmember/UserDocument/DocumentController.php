<?php

namespace App\Http\Controllers\Nonmember\UserDocument;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDocuments;
use App\Models\UserDocumentType;
use Illuminate\Support\Str;
use App\Http\Requests\Nonmember\Document\DocumentStoreRequest;
use App\Http\Requests\Nonmember\Document\DocumentUpdateRequest;

class DocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::where('user_id', auth()->id())->get();
        return view('non-member.user-document.index', compact('docs'));
    }

    public function create()
    {
        $types = UserDocumentType::all();
        return view('non-member.dashboard.index', compact('types'));
    }

    public function store(DocumentStoreRequest $request)
    {
        dd($request->all());
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'image_') && $value) {
                $doc = new UserDocuments();
                $doc->user_id = $request->user()->id;
                $doc->user_document_type_id = $request->input('user_document_type_id_' . Str::after($key, 'image_'));
                $this->uploadImage($request, $key, $doc);
                $doc->save();
            }
        }

        return redirect()->route('member.documents.index')->with('success', 'Document created successfully.');
    }

    private function uploadImage(Request $request, $inputName, $doc)
    {
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);
            $imageName = time() . '_' . Str::slug($image->getClientOriginalName());
            $image->storeAs('images', $imageName);
            $doc->$inputName = $imageName;
        }
    }

    public function edit(UserDocuments $document)
    {
        return view('non-member.document.edit', compact('document'));
    }

    public function update(DocumentUpdateRequest $request, UserDocuments $document)
    {
        $document->user_id = $request->user()->id;
        $document->user_document_type_id = $request->user_document_type_id;

        if ($request->hasFile('image')) {
            $this->uploadImage($request, 'image', $document);
        }

        $document->save();
        return redirect()->route('member.documents.index')->with('success', 'Document updated successfully.');
    }
}
