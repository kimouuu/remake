@extends('layouts.member.template-member')

@section('content-member')
<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">

<div class="container mt-5">
    <h1 class="text-center">Dokumen</h1>
    <a href="{{ route('member.documents.create') }}" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i></a>

    @foreach($docs as $document)
    <div class="card">
        <div class="card-body">
        <div class="card mb-2" style="max-width: 900px">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center">
                    <img src="{{ asset($document->image) }}" alt="{{ $document->image }}" class="img-fluid rounded-start" style="width: 200px; height: 200px;">
                </div>

                <div class="col-md-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $document->type->name }}</h5>
                            <a href="{{ route('member.documents.edit', $document->id) }}" class="btn btn-warning mt-1"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
        @endforeach

</div>
@endsection
