@extends('layouts.admin.template-admin')
@section('content-admin')
    <title>Tambah Jenis Dokumen | {{ $setting->community_name }}</title>
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
                    <div class="form-group">
                        <label for="type"> Tipe </label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="text">Text</option>
                            <option value="image">Gambar</option>
                            <option value="select">Select</option>
                        </select>
                    </div>
                    <div id="selectOptions" style="display:none;">
                        <label for="select_options">Pilihan Select</label>
                        <div class="option-container">
                            <div class="input-group mb-3">
                                <input type="text" name="select_options[]" class="form-control" placeholder="Masukkan opsi">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary removeOption" type="button">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addOption" class="btn btn-secondary">Tambah Opsi</button>
                    </div>
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
                $('input[name="select_options[]"]').prop('disabled', false); // Aktifkan input
            } else {
                $('#selectOptions').hide(); // Sembunyikan input opsi tambahan
                $('input[name="select_options[]"]').prop('disabled', true); // Nonaktifkan input
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
