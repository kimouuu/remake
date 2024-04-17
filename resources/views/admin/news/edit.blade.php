@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Edit Berita | {{ $setting->community_name }}</title>
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="">
        <h2>Edit News</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-text-input id="title" label="Title" type="text" name="title" :value="$news->title" required="true" />
                    <x-text-input id="description" label="Description" type="text" name="description" :value="$news->description" required="true" />
                    <div class="mb-3">
                        <a href="{{ asset($news->image) }}" style="max-width: 200px; max-height: 150px;">
                            <img src="{{ asset($news->image) }}" alt="News Image" style="max-width: 200px; max-height: 150px;">
                        </a>
                    <x-file-input id="image" label="Image" type="file" name="image" />
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i></button>
                </form>
            </div>
@endsection
