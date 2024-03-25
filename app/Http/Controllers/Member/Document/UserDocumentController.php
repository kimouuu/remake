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
        return view('member.document.index', compact('docs', 'types', 'setting'));
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
            'input_or_image' => 'required_if:user_document_type_id.*,2|mimes:jpg,png,jpeg|max:2048', // Sesuaikan dengan kebutuhan validasi Anda
        ]);

        $doc = new UserDocuments();
        $doc->user_id = $request->user()->id;
        $doc->user_document_type_id = $request->user_document_type_id;

        // Memeriksa jenis input
        if ($request->hasFile('input_or_image')) {
            $imagePath = $this->uploadImage($request->file('input_or_image'), 'uploads/documents', $doc);
            $doc->input = $imagePath;
        } else {
            $doc->input = $request->input('input_text');
        }

        $doc->save();

        return redirect()->route('member.documents.index')->with('success', 'Document uploaded successfully.');
    }


    private function uploadImage($file, $folder, $doc)
    {
        $slug = Str::slug($file->getClientOriginalName());
        $newFileName = time() . '_' . $slug;
        $file->move(public_path($folder), $newFileName); // Ubah jalur penyimpanan gambar
        return $folder . '/' . $newFileName;
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
