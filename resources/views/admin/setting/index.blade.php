@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Pengaturan | {{ $setting->community_name }}</title>
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="">
        <h2>Pengaturan</h2>
        @if ($message = session('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive mt-3 rounded">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">History</th>
                            <th scope="col">Community Bio</th>
                            <th scope="col">Image</th>
                            <th scope="col">Video</th>
                            <th scope="col">Video1</th>
                            <th scope="col">Video2</th>
                            <th scope="col">Community Structure</th>
                            <th scope="col">Slogan</th>
                            <th scope="col">Community Name</th>
                            <th scope="col">Endpoint</th>
                            <th scope="col">Sender</th>
                            <th scope="col">Api Key</th>
                            <th scope="col">Api Token</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $item)
                            <tr>
                                <td>{{ $item->history }}</td>
                                <td>{{ $item->community_bio }}</td>
                                <td>
                                    <a href="{{ asset($item->image) }}" style="max-width: 150px; max-height: 150px;">
                                        <img src="{{ asset($item->image) }}" alt="Setting Image" style="max-width: 200px; max-height: 150px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset($item->video) }}" style="max-width: 150px; max-height: 150px;">
                                        <img src="{{ asset($item->video) }}" alt="Setting Video" style="max-width: 200px; max-height: 150px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset($item->video1) }}" style="max-width: 150px; max-height: 150px;">
                                        <img src="{{ asset($item->video1) }}" alt="Setting Video1" style="max-width: 200px; max-height: 150px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset($item->video2) }}" style="max-width: 150px; max-height: 150px;">
                                        <img src="{{ asset($item->video2) }}" alt="Setting Video2" style="max-width: 200px; max-height: 150px;">
                                    </a>
                                </td>
                                <td>{{ $item->community_structure }}</td>
                                <td>{{ $item->slogan }}</td>
                                <td>{{ $item->community_name }}</td>
                                <td>{{ $item->endpoint }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->api_key }}</td>
                                <td>{{ $item->api_token }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.settings.edit', $item->id) }}" class="btn btn-primary btn-sm mr-4">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
