@extends('layouts.admin.template-admin')
@section('content-admin')
<title>{{ $setting->name }} | Edit Profile</title>
<div class="">
    <h2>Edit Profile</h2>
    <div class="card">
        <div class="card-body col-12 col-md-8">
                <form method="POST" action="{{ route('admin.profiles.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <x-text-input name="name" label="Nama" required :value="$user->name" />
                    <x-text-input name="phone" label="No. Telp" required :value="$user->phone" />
                    <x-text-input name="email" label="Email" required :value="$user->email" />

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
        </div>
    </div>

        <h2>Edit Password</h2>
    <div class="card">
        <div class="card-body col-12 col-md-8">
    <form action="{{ route('admin.profiles.updatePassword', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-text-input name="new_password" label="Password Baru" type="password" required />
        <x-text-input name="new_password_confirmation" label="Konfirmasi Password Baru" type="password" required />

        <button type="submit" class="btn btn-primary">Simpan Password</button>
    </form>
    </div>
</div>
@endsection
