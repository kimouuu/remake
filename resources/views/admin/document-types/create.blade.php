@extends('layouts.admin.template-admin')
@section('content-admin')
<div class="">
    <h2>Jenis Dokumen Pengguna</h2>
    <div class="card">
    <div class="card-body">
    <form action="{{ route('admin.document-types.store') }}" method="post">
        @csrf
        <div class="form-group">
            <x-text-input id="name" name="name" label="Nama" required />
        </div>
        <div class="form-group">
            <label for="status">Status</label>
           <select name="status" id="status" class="form-control" required>
               <option value="required">Required</option>
               <option value="non-required">Non-Required</option>
              </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    </div>
    </div>
</div>
@endsection
