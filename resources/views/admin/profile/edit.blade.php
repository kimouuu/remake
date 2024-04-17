@extends('layouts.admin.template-admin')
@section('content-admin')
<title>Edit Profile | {{ $setting->community_name }}</title>
<div class="">
    <h2>Edit Profile</h2>
    <div class="card">
        <div class="card-body col-12 col-md-8">
                <form method="POST" action="{{ route('admin.profiles.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <x-text-input name="name" label="Nama" required :value="$user->name" />
                    <x-text-input name="fullname" label="Nama Lengkap" required :value="$user->fullname" />
                    <x-text-input readonly name="phone" label="No. Telp" required :value="$user->phone" />
                    <x-text-input readonly name="email" label="Email" required :value="$user->email" />
                    <x-text-input type="date" name="date_birth" label="Tanggal Lahir" required :value="$user->date_birth" />
                    <x-text-input name="address" label="Alamat" required :value="$user->address" />
                    <x-text-input name="province" label="Provinsi" required :value="$user->province" />
                    <x-text-input name="city" label="Kota" required :value="$user->city" />
                    <x-text-input name="district" label="Kecamatan" required :value="$user->district" />
                    <x-text-input name="postal_code" label="Kode Pos" required :value="$user->postal_code" />
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
        <div class="form-group position-relative has-icon-left mb-4">
            <div class="input-group">
                <input type="password" class="form-control form-control-xl" name="password" id="passwordInput" placeholder="Kata Sandi">
                <span class="input-group-text" id="eyePosition" onclick="togglePasswordVisibility('passwordInput', 'eyeIcon')">
                    <i id="eyeIcon" class="bi bi-eye-fill"></i>
                </span>
                <div class="form-control-icon">
                <i class="bi bi-lock"></i>
            </div>
            </div>

        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <div class="input-group">
                <input type="password" class="form-control form-control-xl" name="password_confirmation" id="confirmPasswordInput" placeholder="Konfirmasi Sandi">
                <span class="input-group-text" id="confirmEyePosition" onclick="togglePasswordVisibility('confirmPasswordInput', 'confirmEyeIcon')">
                    <i id="confirmEyeIcon" class="bi bi-eye-fill"></i>
                </span>
                <div class="form-control-icon">
                <i class="bi bi-lock"></i>
            </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Simpan Password</button>
    </form>
    </div>
</div>
<script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
<script>
    function togglePasswordVisibility(inputId, iconId) {
        var passwordInput = document.getElementById(inputId);
        var eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye-fill');
            eyeIcon.classList.add('bi-eye-slash-fill');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash-fill');
            eyeIcon.classList.add('bi-eye-fill');
        }
    }
</script>
@endsection
