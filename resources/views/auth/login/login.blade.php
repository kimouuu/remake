<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
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

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="#"></a>
                    </div>
                    <h2 class="auth-title">Log in</h2>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="phone" name="phone" class="form-control form-control-xl" placeholder="Phone"
                                required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-xl" name="password" id="passwordInput" placeholder="Password">
                                <span class="input-group-text" id="eyePosition" onclick="togglePasswordVisibility()">
                                    <i id="eyeIcon" class="bi bi-eye-fill"></i>
                                </span>
                                <div class="form-control-icon">
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" id="flexCheckDefault" name="remember">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Log in</button>
                    </form>
                    <div class="text-center mt-3 text-lg fs-6 mb-1">
                        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                                class="font-bold">Sign up</a></p>
                        <p>
                        <a class="font-bold" href="#">Forgot password?</a>.</p>
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
