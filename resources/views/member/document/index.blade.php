@extends('layouts.member.template-member')

@section('content-member')
<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">

<div class="container mt-5">
    <h1 class="text-center">Dokumen</h1>
    <a href="{{ route('member.documents.create') }}" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i></a>

    @foreach($docs as $document)
        @foreach($types as $type)
            @if($type->id == $document->user_document_type_id)
                <div class="card">
                    <div class="card-body">
                        <div class="card mb-2" style="max-width: 900px">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    @if($type->type == 'image')
                                        <img src="{{ asset($document->input) }}" alt="{{ $document->input }}" class="img-fluid rounded-start" style="width: 200px; height: 200px;">
                                    @elseif($type->type == 'text')
                                        <p>{{ $document->input }}</p>
                                    @endif
                                </div>

                                <div class="col-md-5">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title">{{ $type->name }}</h5> <!-- Accessing the name of the document type -->
                                            @if(!$document->verified_at)
                                            <a href="{{ route('member.documents.edit', $document->id) }}" class="btn btn-warning mt-1"><i class="bi bi-pencil-square"></i></a>
                                        @endif
                                        </div>
                                        <hr>
                                        <p class="card-text">Di Verifikasi Pada : {{ $document->verified_at }}</p>
                                        <p class="card-text">Oleh : {{ $document->verifiedBy?->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
@endsection
