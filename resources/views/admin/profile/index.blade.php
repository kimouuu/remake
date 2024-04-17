@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Profile | {{ $setting->community_name }}</title>
<div class="">
    <h2>Profile</h2>
    <div class="card">
        <div class="card-body">
            <table class="table mb-3">
                <tbody>
                    <tr>
                        <th scope="row">Nama </th>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nama Lengkap</th>
                        <td>:</td>
                        <td>{{ $user->fullname }}</td>
                    </tr>
                    <tr>
                        <th scope="row">No. Telp</th>
                        <td>:</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Lahir</th>
                        <td>:</td>
                        <td>{{ $user->date_birth }}</td>
                    </tr>

                    <tr>
                        <th scope="row">Alamat</th>
                        <td>:</td>
                        <td>{{ $user->address }}, {{ $user->province }}, {{ $user->city }}, {{ $user->district }}, {{ $user->postal_code }}</td>
                    </tr>


                </tbody>
            </table>
            <div class="p-2">
                <a href="{{route('admin.profiles.edit', $user->id)}}" method="POST" class="btn btn-primary mb-2">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
