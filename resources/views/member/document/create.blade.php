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
                            <div class="form-group">
                                <label for="user_document_type_id">Jenis Dokumen</label>
                                <select name="user_document_type_id" id="user_document_type_id" class="form-control">
                                    <option value="">Pilih Jenis Dokumen</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" data-type="{{ $type->type }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_document_type_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="fileInputSection">
                                <label for="input_or_image">Upload Dokumen</label>
                                <input type="file" name="input_or_image" id="input_or_image" class="form-control">
                                @error('input_or_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="textInputSection" style="display: none;">
                                <label for="input_text">Input Text</label>
                                <input type="text" name="input_text" id="input_text" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('user_document_type_id');
            var fileInputSection = document.getElementById('fileInputSection');
            var textInputSection = document.getElementById('textInputSection');

            typeSelect.addEventListener('change', function() {
                var selectedOption = typeSelect.options[typeSelect.selectedIndex];
                var selectedType = selectedOption.getAttribute('data-type');

                // Hide both input sections first
                fileInputSection.style.display = 'none';
                textInputSection.style.display = 'none';

                // Show the input section based on the selected option
                if (selectedType === 'text') {
                    textInputSection.style.display = 'block';
                } else if (selectedType === 'image') {
                    fileInputSection.style.display = 'block';
                }
            });
        });
    </script>

@endsection
