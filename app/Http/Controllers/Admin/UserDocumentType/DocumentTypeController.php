<?php

namespace App\Http\Controllers\Admin\UserDocumentType;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserDocumentType\DocumentTypeStoreRequest;
use App\Models\UserDocumentType;
use App\Models\Setting;
use App\Models\UserDocumentTypeSelect;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrFail();
        $documentType = UserDocumentType::all();
        return view('admin.document-types.index', compact('documentType', 'setting'));
    }

    public function create()
    {
        $setting = Setting::firstOrFail();
        return view('admin.document-types.create', compact('setting'));
    }

    public function store(Request $request)
    {
        // Validasi data formulir
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:required,non-required',
            'type' => 'required|in:text,image,select',
            'select_options' => 'required_if:type,select|array', // Hanya diperlukan jika tipe adalah 'select'
            'select_options.*' => 'string|max:255' // Validasi setiap nilai opsi pilihan
        ]);

        // Buat entri baru dalam tabel 'user_document_types'
        $userDocumentType = UserDocumentType::create([
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
            'type' => $validatedData['type']
        ]);

        // Jika tipe yang dipilih adalah 'select'
        if ($validatedData['type'] === 'select') {
            // Buat entri baru dalam tabel 'user_document_type_select' dan hubungkan dengan 'user_document_type'
            foreach ($validatedData['select_options'] as $selectOption) {
                $userDocumentType->userDocumentTypeSelect()->create([
                    'select_option' => $selectOption
                ]);
            }
        }

        // Redirect ke halaman yang sesuai
        return redirect()->route('admin.document-types.index');
    }



    public function edit(UserDocumentType $documentType)
    {
        $setting = Setting::firstOrFail();
        return view('admin.document-types.edit', compact('documentType', 'setting'));
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
