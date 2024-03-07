@extends('layouts.admin.template-admin')
@section('content-admin')
<div class="">
     <h2>Jenis Dokumen Pengguna</h2>
    <div class="card">
        <div class="card-body">
    <a href="{{ route('admin.document-types.create') }}" class="btn btn-primary mb-2">Tambah</a>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentType as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->status }}</td>
                    <td>
                        <a href="{{ route('admin.document-types.edit', $type->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.document-types.destroy', $type->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this document type?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
@endsection
