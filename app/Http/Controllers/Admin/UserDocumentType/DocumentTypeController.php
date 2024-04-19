<?php

namespace App\Http\Controllers\Admin\UserDocumentType;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserDocumentType\DocumentTypeStoreRequest;
use App\Models\UserDocumentType;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|in:required,non-required',
            'type' => 'required|in:text,image,select',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lanjutkan menyimpan data jika validasi berhasil
        $userDocumentType = UserDocumentType::create([
            'name' => $request->name,
            'status' => $request->status,
            'type' => $request->type
        ]);

        // Jika tipe yang dipilih adalah 'select', simpan juga pilihan-pilihannya
        if ($request->type === 'select') {
            $selectOptions = $request->select_options;
            $userDocumentTypeSelect = [];
            foreach ($selectOptions as $option) {
                $userDocumentTypeSelect[] = new UserDocumentTypeSelect([
                    'select_option' => $option
                ]);
            }
            $userDocumentType->userDocumentTypeSelect()->saveMany($userDocumentTypeSelect);
        }

        // Redirect ke halaman yang sesuai
        return redirect()->route('admin.document-types.index');
    }

    public function edit($id)
    {
        $documentType = UserDocumentType::with('userDocumentTypeSelect')->findOrFail($id);

        $setting = Setting::firstOrFail();
        return view('admin.document-types.edit', compact('documentType', 'setting'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data formulir
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|in:required,non-required',
            'type' => 'required|in:text,image,select',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('type') === 'select') {
            $request->validate([
                'select_options' => 'required|array',
                'select_options.*' => 'string|max:255'
            ]);
        }

        // Perbarui data jenis dokumen
        $documentType = UserDocumentType::findOrFail($id);
        $documentType->name = $request->name;
        $documentType->status = $request->status;
        $documentType->type = $request->type;
        $documentType->save();

        // Perbarui opsi select jika tipe adalah 'select'
        if ($request->input('type') === 'select') {
            $documentType->userDocumentTypeSelect()->delete(); // Hapus opsi yang ada
            foreach ($request->select_options as $selectOption) {
                $documentType->userDocumentTypeSelect()->create([
                    'select_option' => $selectOption
                ]);
            }
        }

        // Redirect ke halaman yang sesuai
        return redirect()->route('admin.document-types.index');
    }


    public function destroy(UserDocumentType $documentType)
    {
        $documentType->delete();
        return redirect()->route('admin.document-types.index');
    }
}
