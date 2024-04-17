@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Tambah Berita  | {{ $setting->community_name }}</title>
<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
<div class="">
    <h2>Create News</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-text-input id="title" label="Title" type="text" name="title" required="true" />
                <x-text-input id="description" label="Description" type="text" name="description" required="true" />
                <x-file-input id="image" label="Image" type="file" name="image" required="true" />
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i></button>
            </form>
        </div>
    </div>
</div>
@endsection
