@extends('layouts.admin.template-admin')
@section('content-admin')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="container mt-5">
        <h1 class="text-center">Show News</h1>
        <div class="card mb-3" style="max-width: 900px">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center">
                    <img src="{{ asset($news->image) }}" alt="{{ $news->image }}" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $news->title }}</h5><hr>
                        <p class="card-text">{!! $news->description !!}</p>

                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left-circle"></i></a>
    </div>

@endsection
