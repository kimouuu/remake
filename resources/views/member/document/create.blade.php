@extends('layouts.member.template-member')
@section('content-member')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Document</h1>

                <div class="card">
                    <div class="card-body">
                <form action="{{ route('member.documents.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" >
                        <label for="type_id">Jenis Dokumen</label>
                        <select name="type_id" id="type_id" class="form-control">
                            <option value="">Pilih Jenis Dokumen</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                        <x-file-input id="image" label="Image" type="file" name="image" required="true" />
                    </div>
                    <div class="form-group" style="width: 50%">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>

@endsection
