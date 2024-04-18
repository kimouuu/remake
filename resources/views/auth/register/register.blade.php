<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register | {{ $setting->community_name }}</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.16.0/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    @if(session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('setting_image/wayang.png') }}" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Daftar</h1>
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">

                            <input type="text" class="form-control form-control-xl" name="name" placeholder="Nama Panggilan">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="phone" placeholder="No. Handphone">
                             <div class="form-control-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>

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

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Daftar</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>

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

</body>

</html>
