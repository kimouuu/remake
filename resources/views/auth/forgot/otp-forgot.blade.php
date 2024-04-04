<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP - Mazer Admin Dashboard</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}">
    <!-- Add any additional styles if needed -->
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <h1 class="auth-title">OTP</h1>

                    <!-- Display success message if OTP is sent -->
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display error message if exists -->
                    @if(session('error'))
                        <div class="alert alert-danger mt-3" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('forgot.otp-verification.store', $user->id) }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="otp" placeholder="OTP">
                            <div class="form-control-icon">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Submit</button>
                    </form>

                    <p class="text-center mt-2" id="otpMessage">
                        @php
                            $censoredContact = ($user->userOtp->otp_type == 'email') ? $user->email : substr_replace($user->phone, '*****', -5);
                        @endphp

                        @if ($user)
                            <span>
                                *Kode OTP terkirim ke {{ $censoredContact }} via
                                @if ($user->userOtp->otp_type == 'email')
                                    email.
                                @elseif ($user->userOtp->otp_type == 'whatsapp')
                                    WhatsApp.
                                @endif
                            </span>
                        @endif
                    </p>

                    <!-- Resend button and countdown -->
                    <form id="resendOtpForm" action="{{ route('register.verificationOtp.resendOtpCode', $user->id) }}" method="post">
                        @csrf
                        <button id="resendOtpButton" class="btn btn-secondary btn-block btn-lg shadow-lg mt-3" disabled>Resend OTP</button>
                        <p id="countdown" style="display: none;"></p>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <!-- Additional content on the right if needed -->
                </div>
            </div>
        </div>
    </div>

    <!-- Di dalam dokumen HTML -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($user->userOtp)
                var expiredAt = '{{ $user->userOtp->expired_at }}'; // Ambil nilai expired_at dari variabel yang dikirim dari kontroler
                var censoredContact = document.getElementById('censoredContact');
                var resendButton = document.getElementById('resendOtpButton');
                var countdownElement = document.getElementById('countdown');

                function updateCountdown() {
                    var remainingTime = new Date(expiredAt) - new Date();
                    var minutes = Math.floor(remainingTime / (1000 * 60)); // Konversi milidetik ke menit
                    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000); // Sisa waktu dalam detik

                    if (minutes <= 0 && seconds <= 0) {
                        enableResendButton();
                    } else {
                        countdownElement.style.display = 'block';
                        countdownElement.innerText = 'Resend OTP in ' + minutes + ' menit ' + seconds + ' detik';
                    }
                }

                function enableResendButton() {
                    resendButton.style.display = 'block';
                    resendButton.removeAttribute('disabled');
                    countdownElement.style.display = 'none';
                }

                // Menggunakan data dari atribut HTML di dalam skrip JavaScript
                censoredContact.innerText = '*Kode OTP terkirim ke ' + censoredContact.getAttribute('data-censored-contact') + ' via {{ $user->userOtp->otp_type }}';

                // Tambahkan countdown
                updateCountdown();
                var countdownInterval = setInterval(updateCountdown, 1000);

                // Hentikan interval countdown setelah waktu berakhir
                setTimeout(function () {
                    clearInterval(countdownInterval);
                    enableResendButton();
                }, new Date(expiredAt) - new Date());
            @else
                console.error('User OTP data is missing.');
            @endif
        });
    </script>

    <!-- Include your JavaScript files here -->
</body>

</html>