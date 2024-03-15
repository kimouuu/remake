<?php

namespace App\Http\Controllers\Member\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Document\DocumentStoreRequest;
use App\Http\Requests\Member\Document\DocumentUpdateRequest;
use App\Models\UserDocuments;
use App\Models\UserDocumentType;
use Illuminate\Validation\Rule;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::all();
        $types = UserDocumentType::all();
        $setting = Setting::first();
        return view('member.document.index', compact('docs'));
    }

    public function create()
    {
        $setting = Setting::first();
        $types = UserDocumentType::all();
        return view('member.document.create', compact('types'));
    }

    public function store(DocumentStoreRequest $request)
    {
        $request->validate([
            'user_document_type_id' => [
                'required',
                Rule::unique('user_documents', 'user_document_type_id')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                }),
            ],
        ]);

        $doc = new UserDocuments();
        $doc->user_id = $request->user()->id;
        $doc->type_id = $request->type_id;
        $doc->image = null;
        $this->uploadImage($request, 'image', 'image', $doc);
        $doc->save();

        return redirect()->route('member.documents.index')->with('success', 'Document created successfully.');
    }

    private function uploadImage(Request $request, $inputName, $folder, $doc)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $doc->$inputName = $folder . '/' . $newFileName;
        }
    }

    public function edit(UserDocuments $document)
    {
        return view('member.document.edit', compact('document'));
    }

    public function update(DocumentUpdateRequest $request, UserDocuments $document)
    {

        $request->validate([
            'user_document_type_id' => [
                'required',
                Rule::unique('user_documents', 'user_document_type_id')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })->ignore($request->id),
            ],
        ]);

        $document->user_id = $request->user()->id;
        $document->type_id = $request->type_id;
        $document->image = null;
        $this->updateImage($request, 'image', 'image', $document);
        $document->save();
        return redirect()->route('member.documents.index')->with('success', 'Document updated successfully.');
    }

    private function updateImage(Request $request, $inputName, $folder, $document)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $document->$inputName = $folder . '/' . $newFileName;
        } elseif ($request->has($inputName . '_remove')) {
            $document->$inputName = null;
        }
    }

    public function destroy(UserDocuments $doc)
    {
        $doc = UserDocuments::find($doc->id);
        $doc->delete();
        return redirect()->route('member.documents.index')->with('success', 'Document deleted successfully.');
    }
}
