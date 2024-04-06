<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot - Mazer Admin Dashboard</title>
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
                    <h2 class="auth-title">Lupa Password</h2>
                    <form action="{{ route('forgot.send-otp') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="via" class="form-label">Via</label>
                            <select class="form-select" name="via" id="via" required>
                                <option value="email">Email</option>
                                <option value="phone">No. Handphone</option>
                            </select>
                        </div>
                        <div class="form-group" id="inputField">
                            <!-- Input field for email -->
                            <input type="email" name="email" id="email" class="form-control" placeholder="Alamat Email">
                            <!-- Input field for phone number -->
                            <input type="number" name="phone" id="phone" class="form-control" placeholder="Nomor Handphone" style="display: none;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Kirim</button>
                    </form>

                    <div class="text-center mt-3 text-lg fs-6 mb-1">
                        <p class="text-gray-600">Sudah ingat password? <a href="{{ route('login') }}"
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
        // Function to toggle visibility of input fields based on selected option
        document.getElementById("via").addEventListener("change", function() {
            var via = this.value;
            if (via === "email") {
                document.getElementById("email").style.display = "block";
                document.getElementById("phone").style.display = "none";
            } else if (via === "phone") {
                document.getElementById("phone").style.display = "block";
                document.getElementById("email").style.display = "none";
            }
        });
    </script>

</body>
</html>
