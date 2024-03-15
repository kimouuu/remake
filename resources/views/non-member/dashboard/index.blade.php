@extends('layouts.non-member.template-non-member')
@section('content-non-member')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <h1>Dashboard</h1>
    <p>This is the dashboard for non-members.</p>
    <div class="row">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lengkapi Dokumen Data dirimu!</h5>
                    <p class="card-text">Ayo Lengkapi Dokumenmu!</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">Lengkapi</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Lengkapi Dokumen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('non-member.documents.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @foreach($types as $type)
                            <div class="form-group">
                                <label for="image_{{ $type->id }}">
                                    Jenis Dokumen: {{ $type->name }}
                                    @if($type->status === 'required')
                                        <span class="text-danger">*</span> <!-- Star icon for required document type -->
                                    @endif
                                </label>
                                <input type="file" name="image_{{ $type->id }}" class="form-control" id="image_{{ $type->id }}" required onchange="document.getElementById('user_document_type_id').value = {{ $type->id }};">

                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->role === 'non-member')
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Member</h5>
                    <p class="card-text">Ayo bergabung sebagai member!</p>
                    <form action="{{ route('member.user.register') }}" method="post" id="registrationForm">
                        @csrf
                        <button type="submit" class="btn btn-primary" id="registerButton">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    @endif


        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('registerButton').addEventListener('click', function(event) {
                event.preventDefault();
                var form = event.target.form;

                // Periksa apakah ada pesan kesalahan dalam sesi
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ session('error') }}'
                    });
                @else
                    Swal.fire({
                        title: 'Anda yakin ingin mendaftar?',
                        text: 'Setelah mendaftar, Anda tidak akan bisa mengubahnya!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, daftar saja!',
                        cancelButtonText: 'Tidak, batal!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                @endif
            });
        </script>


@endsection
