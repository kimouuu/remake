@extends('layouts.admin.template-admin')
@section('content-admin')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="">
        <h2>Tambah Event</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-text-input id="name" label="Nama" type="text" name="name" required="true" />
                    <x-text-input id="date" label="Tanggal" type="date" name="date" required="true" />
                    <x-text-input id="location" label="Lokasi" type="text" name="location" required="true" />
                    <x-text-input id="description" label="Deskripsi" type="text" name="description" required="true" />
                    <x-text-input id="image" label="Gambar" type="file" name="image" required="true" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
