@extends('layouts.admin.template-admin')
@section('content-admin')
<title>{{ $setting->name }} | Profile</title>
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
                        <th scope="row">No. Telp</th>
                        <td>:</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>:</td>
                        <td>{{ $user->email }}</td>
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
