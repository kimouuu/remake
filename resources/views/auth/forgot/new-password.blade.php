<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Mazer Admin Dashboard</title>
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
                        <div class="form-group">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Password Baru">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Konfirmasi Password Baru">
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
</body>

</html>
