@extends('layouts.admin.template-admin')

@section('content-admin')
<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">

<div class="">
    <h2>Event</h2>
    @if ($message = session('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">

            <a href="{{ route('admin.events.create') }}" class="btn btn-success mb-3"><i class="bi bi-plus-lg"></i></a>

            <div class="table-responsive mt-3 rounded">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $no => $item)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ Str::limit($item->description, 40) }}</td>
                                <td>
                                    <a href="{{ asset($item->image) }}" style="max-width: 150px; max-height: 150px;">
                                        <img src="{{ asset($item->image) }}" alt="Event Image" style="max-width: 200px; max-height: 150px;">
                                    </a>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.events.show', $item->id) }}" class="btn btn-info btn-sm mr-4">
                                        <i class="bi bi-exclamation-circle"></i>
                                    <a href="{{ route('admin.events.edit', $item->id) }}" class="btn btn-primary btn-sm mr-4">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $item->id) }}" onsubmit="return confirm('Yakin Mau Dihapus?')" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('mazer/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('mazer/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection
