@extends('layouts.member.template-member')

@section('content-member')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h1>Edit Dokumen</h1>

            <!-- Menampilkan pesan kesalahan validasi -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('member.documents.update', $document->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="types">Jenis Dokumen</label>
                            <select name="types" id="types" class="form-select" >
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ $document->user_document_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tampilkan input teks jika jenis dokumen adalah 'text' -->
                        @if ($document->types->type == 'text')
                        <div class="form-group">
                            <label for="input">Isi Dokumen</label>
                            <textarea name="input" id="input" class="form-control"
                                rows="5">{{ $document->input }}</textarea>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="input">File</label>
                            <input type="file" name="input" id="input" class="form-control">
                        </div>
                        <!-- Tampilkan gambar lama jika sudah ada input file sebelumnya -->
                        @if ($document->input)
                        <div class="form-group">
                            <label for="old_image">Gambar Lama</label><br>
                            <img src="{{ asset($document->input) }}" alt="Old Image" style="max-width: 300px;">
                        </div>
                        @endif
                        @endif

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
