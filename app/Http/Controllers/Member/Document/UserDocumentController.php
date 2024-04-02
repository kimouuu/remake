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
use Illuminate\Support\Facades\DB;

class UserDocumentController extends Controller
{
    public function index()
    {
        $docs = UserDocuments::when(auth()->user()->role !== 'admin', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

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

    public function store(Request $request)
    {
        $request->validate([
            'types' => 'required|array',
        ]);


        DB::transaction(function () use ($request) {
            foreach ($request->types as $key => $type) {

                if ($key === 'image') {
                    $doc = new UserDocuments();
                    $doc->user_id = $request->user()->id;
                    $doc->user_document_type_id = $type;

                    if ($request->has('file')) {
                        $imagePath = $this->uploadImage($request->file('file'), 'uploads/documents', $doc);
                        $doc->input = $imagePath;
                    }

                    $doc->save();
                }

                if ($key === 'text') {
                    $doc = new UserDocuments();
                    $doc->user_id = $request->user()->id;
                    $doc->user_document_type_id = $type;

                    if ($request->has('text')) {
                        $doc->input = $request->input('text');
                    }

                    $doc->save();
                }
            }
        });

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
        $types = UserDocumentType::all();
        return view('member.document.edit', compact('document', 'types'));
    }

    public function update(Request $request, UserDocuments $document)
    {
        // Validasi input
        $validated = $request->validate([
            'types' => 'required|string',
            'input' => 'required', // Tidak perlu validasi spesifik untuk jenis input (teks atau gambar)
        ]);

        // Jika input adalah gambar, panggil fungsi untuk mengupdate gambar
        if ($request->hasFile('input')) {
            $this->updateImage($request, 'input', 'uploads/documents', $document);
            $inputValue = $document->input; // Gunakan nilai yang sudah diupdate setelah proses
        } else {
            // Jika input bukan gambar, gunakan nilai teks yang diberikan
            $inputValue = $request->input('input');
        }

        // Update data dokumen
        $document->update([
            'user_document_type_id' => $validated['types'],
            'input' => $inputValue,
            'verified_by' => null,
            'reason' => null,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('member.documents.index')->with('success', 'Document updated successfully');
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
