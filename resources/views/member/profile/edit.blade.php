@extends('layouts.member.template-member')

@section('content-member')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">

    <div class="container mt-5">
        <h2>Edit Profile</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('member.profiles.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="fullname" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $user->fullname }}" required>
                            @error('fullname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">No. Telp</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" readonly class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date_birth" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{ $user->date_birth }}" required>
                            @error('date_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="address" name="address" required>{{ $user->address }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="province" class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="province" name="province" value="{{ $user->province }}" required>
                            @error('province')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="city" class="col-sm-2 col-form-label">Kota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}" required>
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="district" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="district" name="district" value="{{ $user->district }}" required>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="postal_code" class="col-sm-2 col-form-label">Kode Pos</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $user->postal_code }}" required>
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <h2>Edit Password</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('member.profiles.updatePassword', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <x-text-input name="new_password" label="Password Baru" type="password" required />
                    <x-text-input name="new_password_confirmation" label="Konfirmasi Password Baru" type="password" required />
                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
