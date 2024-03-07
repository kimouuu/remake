@extends('layouts.admin.template-admin')
@section('content-admin')
<div class="container mt-5">
    <h1>Detail Event</h1>
    <div class="card mb-3" style="max-width: 900px;">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center">
                <img src="{{ asset($event->image) }}" class="img-fluid rounded-start" alt="{{ $event->name }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5><hr>
                    <p class="card-text">{!! $event->description !!}</p>
                    <p class="card-text"><strong><i class="bi bi-calendar-check"></i></strong> {{ $event->date }}</p>
                    <p class="card-text"><strong><i class="bi bi-pin-fill"></i></strong> {{ $event->location }}</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left-circle"></i></a>
</div>
@endsection
