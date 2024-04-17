@extends('layouts.member.template-member')

@section('content-member')
<title>Profile | {{ $setting->community_name }}</title>
<link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">

<div class="container mt-5">
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
                            <th scope="row">Tanggal Lahir</th>
                            <td>:</td>
                            <td>{{ $user->date_birth }}</td>
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
                            <th scope="row">Alamat</th>
                            <td>:</td>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kecamatan</th>
                            <td>:</td>
                            <td>{{ $user->district }}</td>
                        <tr>
                            <th scope="row">Kota</th>
                            <td>:</td>
                            <td>{{ $user->city }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Provinsi</th>
                            <td>:</td>
                            <td>{{ $user->province }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kode Pos</th>
                            <td>:</td>
                            <td>{{ $user->postal_code }}</td>
                        </tr>


                    </tbody>
                </table>
                <div class="p-2">
                    <a href="{{ route('member.profiles.edit', $user->id) }}" class="btn btn-primary mb-2">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
