<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | {{ $setting->community_name }}</title>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-danger">{{  __("There were {$errors->count()} errors with your submission") }}</li>
                            </ul>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li >{{ $error }}</li>
                                    @endforeach
                            </ul>
                        </div>
                    @endif
                    <h2 class="auth-title">Reset Password</h2>
                    <form action="{{ route('password.reset-store', ['token' => $token, 'user' => $user->id]) }}" method="post">
                        @csrf
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
                        <button type="submit"
                            class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Reset Password</button>
                    </form>

                    <div class="text-center mt-3 text-lg fs-6 mb-1">
                        <p class="text-gray-600">Ingat password? <a href="{{ route('login') }}"
                                class="font-bold">Masuk</a></p>
                        <p>
                            <a class="font-bold" href="{{ route('register') }}">Daftar</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-12">
                <div id="auth-right">
                </div>
            </div>
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
</body>

</html>
