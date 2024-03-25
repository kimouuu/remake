@extends('layouts.member.template-member')
@section('content-member')
    <div class="container">
        <h1>Dashboard</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            @if (auth()->check() && auth()->user()->role === 'non-member')
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Lengkapi Dokumen</h5>
                            <p class="card-text">Lengkapi dokumen Anda untuk menjadi member.</p>
                            <a href="{{ route('member.documents.create') }}" class="btn btn-primary">Lengkapi Dokumen</a>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->check() && auth()->user()->role == 'non-member')
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Member</h5>
                            <p class="card-text">Ayo bergabung sebagai member!</p>
                            <form action="{{ route('member.dashboard.register') }}" method="post" id="registrationForm">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="registerButton">Daftar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Cek apakah pengguna bukan non-member atau member dan belum memverifikasi nomor telepon
        @auth
        @if(Auth::user()->role === 'user' && is_null(Auth::user()->phone_verified_at))
            // Menampilkan SweetAlert dengan pesan verifikasi OTP
            Swal.fire({
                title: "Verifikasi Nomor Telepon",
                text: "Nomor telepon Anda belum diverifikasi. Silakan verifikasi untuk melanjutkan.",
                icon: "warning",
                confirmButtonText : "Verifikasi Sekarang",
                dangerMode: true,
            })
            .then((willVerify) => {
                // Mengarahkan pengguna ke halaman OTP saat tombol Verifikasi Sekarang ditekan
                if (willVerify) {
                    // Mendapatkan user ID
                    var userId = "{{ auth()->user()->id }}";
                    // Memastikan userId tidak kosong
                    if (userId) {
                        console.log("User ID:", userId); // Tambahkan console.log untuk memeriksa nilai userId
                        // Mengarahkan pengguna ke halaman OTP dengan menyertakan user ID
                        // 'register/verification/{userId}
                        window.location.href = "{{ route('register.verificationOtp.index', ['userId' => ':userId']) }}".replace(':userId', userId);
                    } else {
                        console.error("User ID is missing."); // Menampilkan pesan error jika userId kosong
                    }
                }
            });
        @endif

        @if(is_null(Auth::user()->fullname))
            Swal.fire({
                title: "Lengkapi Profil",
                text: "Silakan lengkapi profil Anda terlebih dahulu.",
                icon: "warning",
                confirmButtonText : "Lengkapi Sekarang",
                dangerMode: true,
            })
            .then(() => {
                window.location.href = "{{ route('register.verificationOtp.update', ['userId' => auth()->user()->id]) }}";

            });
        @endif

        @if(is_null(Auth::user()->email_verified_at))
            Swal.fire({
                title: "Verifikasi Email",
                text: "Silakan verifikasi email Anda terlebih dahulu.",
                icon: "warning",
                confirmButtonText : "Verifikasi Sekarang",
                dangerMode: true,
            })
            .then(() => {
                window.location.href = "{{ route('register.verificationMailOtp.index', ['userId' => auth()->user()->id]) }}";

            });
        @endif
    @endauth

        // Menampilkan SweetAlert untuk konfirmasi pendaftaran sebagai member
        document.getElementById('registerButton').addEventListener('click', function(event) {
            event.preventDefault();
            var form = event.target.form;

            Swal.fire({
                title: 'Anda yakin ingin mendaftar?',
                text: 'Setelah mendaftar, Anda tidak akan bisa mengubahnya!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, daftar saja!',
                cancelButtonText: 'Tidak, batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

@endsection
