@extends('layouts.admin.template-admin')
@section('content-admin')
    <div class="container">
        <h2 class="text-center">List Dokumen</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Nama Dokumen</th>
                            <th>File</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docs as $document)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $document->user->name }}</td>
                                <td>{{ $document->type->name }}</td>
                                <td>{{ $document->image }}</td>
                                <td>
                                    <form action="{{ route('admin.document-approved.update', $document->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalDetail{{ $document->id }}">Approve</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
@endsection
