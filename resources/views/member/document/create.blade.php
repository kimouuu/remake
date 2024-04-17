@extends('layouts.member.template-member')
@section('content-member')
<title>Tambah Dokumen | {{ $setting->community_name }}</title>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Document</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('member.documents.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($types as $type)
                                        <li class="d-inline-block me-2 mb-1">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input name="types[{{ $type->type }}]"
                                                        value="{{ $type->id }}"
                                                        data-type-name="{{ $type->name }}"
                                                        data-type="{{ $type->type === 'image' ? 'file' : ($type->type === 'select' ? 'select' : 'text') }}"
                                                        type="checkbox"
                                                        class="form-check-input"
                                                    >
                                                    <label for="type{{ $type->name }}">
                                                        {{ $type->name }}
                                                        @if($type->status === 'required')
                                                            <span style="color: red">*</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @error('types')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </ul>
                            </div>

                            <div class="form-group" id="inputContainer">
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
            var checkboxInputs = document.querySelectorAll('input[type="checkbox"]');
            var inputContainer = document.getElementById('inputContainer');

            checkboxInputs.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    displayInputs();
                });
            });

            function displayInputs() {
                inputContainer.innerHTML = '';

                checkboxInputs.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        var inputType = checkbox.getAttribute('data-type');
                        var inputTypeName = checkbox.getAttribute('data-type-name');
                        var label = document.createElement('label');
                        label.textContent = 'Input for ' + inputTypeName + ': ';
                        var input;

                        if (inputType === 'file') {
                            input = document.createElement('input');
                            input.type = 'file';
                        } else if (inputType === 'select') {
                        input = document.createElement('select');
                        input.name = 'select_option'; // Set nama untuk elemen select
                        input.classList.add('form-control');
                        input.setAttribute('required', '');

                        // Ambil opsi-opsi dari server melalui AJAX
                        fetch('/get-select-options')
                            .then(response => response.json())
                            .then(options => {
                                options.forEach(optionValue => {
                                    var option = document.createElement('option');
                                    option.value = optionValue;
                                    option.textContent = optionValue;
                                    input.appendChild(option);
                                });
                            });

                        } else {
                            input = document.createElement('input');
                            input.type = 'text';
                        }

                        input.name = inputType;
                        input.classList.add('form-control');
                        input.setAttribute('required', '');
                        label.appendChild(input);
                        inputContainer.appendChild(label);
                        inputContainer.appendChild(document.createElement('br'));
                        inputContainer.appendChild(document.createElement('br'));
                    }
                });
            }

            displayInputs();
        });
    </script>
@endsection
