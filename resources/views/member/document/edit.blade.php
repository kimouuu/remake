@extends('layouts.member.template-member')

@section('content-member')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Edit Dokumen</h1>

                <div class="card">
                    <div class="card-body">
                        @if ($document)
                            <form action="{{ route('member.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="type_id">Jenis Dokumen</label>
                                    <!-- Assuming $document->type is the related type model -->
                                    <input type="text" name="type_id" id="type_id" value="{{ $document->type->name }}" class="form-control" disabled required>
                                    <!-- Add any error handling here if needed -->
                                </div>
                                <div class="mb-3">
                                    <a href="{{ asset($document->image) }}" style="max-width: 200px; max-height: 200px;">
                                        <img src="{{ asset($document->image) }}" alt="Document Image" style="width: 300px; max-height: 150px;">
                                    </a>
                                    <div class="form-group">
                                        <label for="image">File</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                            </form>
                        @else
                            <p>Document not found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
