<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | {{ $setting->community_name }}</title>
    <link rel="shortcut icon" href="{{ asset('mazer/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.16.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <script src="{{ asset('mazer/assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="#"></a>
                    </div>
                    <h2 class="auth-title">Masuk</h2>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="phone" name="phone" class="form-control form-control-xl" placeholder="No. Handphone/Email"
                                required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-xl" name="password" id="passwordInput" placeholder="Kata Sandi">
                                <span class="input-group-text" id="eyePosition" onclick="togglePasswordVisibility()">
                                    <i id="eyeIcon" class="bi bi-eye-fill"></i>
                                </span>
                                <div class="form-control-icon">
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Masuk</button>
                    </form>
                    <div class="text-center mt-3 text-lg fs-6 mb-1">
                        <p class="text-gray-600">Tidak punya Akun? <a href="{{ route('register') }}"
                                class="font-bold">Daftar</a></p>
                        <p>
                        <a class="font-bold" href="{{ route('forgot') }}">Lupa password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('passwordInput');
            var eyeIcon = document.getElementById('eyeIcon');

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
