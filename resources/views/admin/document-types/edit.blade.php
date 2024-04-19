@extends('layouts.admin.template-admin')
@section('content-admin')
    <title>Edit Jenis Dokumen | {{ $setting->community_name }}</title>
    <div class="">
        <h2>Edit Jenis Dokumen Pengguna</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.document-types.update', $documentType->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <x-text-input id="name" name="name" label="Nama" :value="$documentType->name" required />
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="required" {{ $documentType->status === 'required' ? 'selected' : '' }}>Required</option>
                            <option value="non-required" {{ $documentType->status === 'non-required' ? 'selected' : '' }}>Non-Required</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type"> Tipe </label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="text" {{ $documentType->type === 'text' ? 'selected' : '' }}>Text</option>
                            <option value="image" {{ $documentType->type === 'image' ? 'selected' : '' }}>Gambar</option>
                            <option value="select" {{ $documentType->type === 'select' ? 'selected' : '' }}>Select</option>
                        </select>
                    </div>
                    <div class="option-container">
                        @foreach($documentType->userDocumentTypeSelect as $option)
                            <div class="input-group mb-3">
                                <input type="text" name="select_options[]" class="form-control" placeholder="Masukkan opsi" value="{{ $option->select_option }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary removeOption" type="button">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="addOption" class="btn btn-secondary">Tambah Opsi</button>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Tangani perubahan pada elemen select
            $('#type').change(function(){
                var selectedType = $(this).val();

                // Periksa jika tipe yang dipilih adalah "select"
                if(selectedType === 'select'){
                    $('#selectOptions').show(); // Tampilkan input opsi tambahan
                } else {
                    $('#selectOptions').hide(); // Sembunyikan input opsi tambahan
                }
            });

            // Tambahkan event listener untuk menambahkan opsi tambahan
            $('#addOption').click(function() {
                var newOptionInput = '<div class="input-group mb-3">';
                newOptionInput += '<input type="text" name="select_options[]" class="form-control" placeholder="Masukkan opsi" required>';
                newOptionInput += '<div class="input-group-append">';
                newOptionInput += '<button class="btn btn-secondary removeOption" type="button">Hapus</button>';
                newOptionInput += '</div></div>';
                $('.option-container').append(newOptionInput);
            });

            // Tangani penghapusan opsi
            $(document).on('click', '.removeOption', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>

@endsection
