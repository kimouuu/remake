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
                                <ul class="list-unstyled mb-0">
                                    @foreach ($types as $type)
                                        <li class="d-inline-block me-2 mb-1">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input name="types[{{ $type->type }}]"
                                                        value="{{ $type->id }}"
                                                        data-type-name="{{ $type->name }}"
                                                        data-type="{{ $type->type === 'image' ? 'file' : 'text' }}"
                                                        type="checkbox" class="form-check-input"
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

    <script>
        const checkboxInputs = document.querySelectorAll('input[type="checkbox"]');

        checkboxInputs.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                displayInputs();
            });
        });

        function displayInputs() {
            const inputContainer = document.getElementById('inputContainer');
            inputContainer.innerHTML = '';

            checkboxInputs.forEach(checkbox => {
                if (checkbox.checked) {
                    const inputType = checkbox.getAttribute('data-type');
                    const inputTypeName = checkbox.getAttribute('data-type-name');
                    const label = document.createElement('label');
                    label.textContent = `Input for ${inputTypeName}: `;
                    const input = document.createElement('input');
                    input.type = inputType === 'file' ? 'file' : 'text';
                    input.name = inputType;
                    input.classList.add('form-control');
                    input.setAttribute('required', '');
                    label.appendChild(input);
                    inputContainer.appendChild(label);
                    inputContainer.appendChild(document.createElement('br'), document.createElement('br'));
                }
            });
        }

        displayInputs();
    </script>
@endsection
