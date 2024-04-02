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
                                <td>{{ $document->types->name }}</td>
                                <td>{{ $document->input }}</td>
                                <td>
                                    <!-- Tautan "Detail" yang membuka modal -->
                                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalDetail{{ $document->id }}">Detail</a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalDetail{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalDetailLabel">Detail Dokumen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Nama Dokumen: {{ $document->types->name }}</p>
                                                    <p>User: {{ $document->user->name }}</p>
                                                    @if (Str::startsWith($document->input, 'uploads/documents'))
                                                    <p>File: <img src="{{ asset($document->input) }}" alt="Document Image" style="max-width: 100%; height: auto;"></p>
                                                @else
                                                    <p>File: {{ $document->input }}</p>
                                                @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form untuk menyetujui dokumen -->
                                    <form action="{{ route('admin.docs-approved.update', $document->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-info">Approve</button>
                                    </form>
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalReject{{ $document->id }}">Reject</a>
                                    <div class="modal fade" id="modalReject{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel{{ $document->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="modalRejectLabel{{ $document->id }}">Reject Dokumen</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form action="{{ route('admin.docs-approved.reject', $document->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                <label for="reason{{ $document->id }}">Alasan Penolakan</label>
                                                <input type="text" class="form-control" id="reason{{ $document->id }}" name="reason" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
