@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Edit Jenis Dokumen | {{ $setting->community_name }}</title>
<div class="">
<h2>Jenis Dokumen Pengguna</h2>
<div class="card">
<div class="card-body">
<a href="{{ route('admin.document-types.index') }}" class="btn btn-primary mb-2">Kembali</a>
<form action="{{ route('admin.document-types.update', $documentType->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <x-text-input id="name" name="name" label="Nama" required :value="$documentType->name" />
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="required" {{ $documentType->status == 'required' ? 'selected' : '' }}>Required</option>
            <option value="non-required" {{ $documentType->status == 'non-required' ? 'selected' : '' }}>Non-Required</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
</div>
</div>
</div>
@endsection
