<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | {{ $setting->community_name }}</title>
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.16.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        #auth-right {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <form action="{{ route('register.verificationOtp.verified', $user->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="fullname">Nama Lengkap: </label>
                            <input value="{{ $user?->fullname }}" id="fullname" type="text" name="fullname" placeholder="Nama Lengkap"
                                class="form-control {{  $errors->has('fullname') ? 'is-invalid' : '' }}" required>
                            @error('fullname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input value="{{ $user?->email }}" id="email" type="email" name="email" placeholder="Email"
                                class="form-control {{  $errors->has('email') ? 'is-invalid' : '' }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin: </label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="Male">Laki-laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date_birth">Tanggal Lahir: </label>
                            <input value="{{ $user?->date_birth }}" id="date_birth" type="date" name="date_birth" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat: </label>
                            <input value="{{ $user?->address }}" id="address" type="text" name="address" placeholder="Alamat"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Provinsi: </label>
                            <input value="{{ $user?->province }}" id="province" type="text" name="province" placeholder="Provinsi"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="city">Kota: </label>
                            <input id="city" value="{{ $user?->city }}" type="text" name="city" placeholder="Kota"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="district">Kecamatan: </label>
                            <input id="district" value="{{ $user?->district }}" type="text" name="district" placeholder="Kecamatan"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Kode Pos: </label>
                            <input id="postal_code" value="{{ $user?->postal_code }}" type="text" name="postal_code" placeholder="Kode Pos"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="d-flex justify-content-center align-items-center">
                    <h1 style="color: white;">Ayo isi Profile Anda!</h1>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('mazer/assets/compiled/js/app-dark.js') }}"></script>
    <script src="{{ asset('mazer/assets/compiled/js/init-scripts.js') }}"></script>
    <!-- Add any additional scripts if needed -->
</body>

</html>
