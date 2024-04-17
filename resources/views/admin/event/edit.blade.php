@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Edit Event | {{ $setting->community_name }}</title>
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="">
        <h2>Edit Event</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-text-input id="name" label="Nama" type="text" name="name" :value="$event->name" required="true" />
                    <x-text-input id="date" label="Tanggal" type="date" name="date" :value="$event->date" required="true" />
                    <x-text-input id="location" label="Lokasi" type="text" name="location" :value="$event->location" required="true" />
                    <x-text-input id="description" label="Deskripsi" type="text" name="description" :value="$event->description" required="true" />
                    <div class="mb-3">
                        <a href="{{ asset($event->image) }}" style="max-width: 200px; max-height: 150px;">
                            <img src="{{ asset($event->image) }}" alt="Event Image" style="max-width: 200px; max-height: 150px;">
                        </a>
                    <x-text-input id="image" label="Gambar" type="file" name="image" />
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i></button>
                </form>
            </div>
        </div>
    </div>

@endsection
