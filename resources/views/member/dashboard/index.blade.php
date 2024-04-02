@extends('layouts.member.template-member')
@section('content-member')
    <div class="container">
        <h1>Dashboard</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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
                            @if(auth()->user()->status == 'process')
                                <button type="button" class="btn btn-primary" disabled>Menunggu Persetujuan</button>
                            @else
                                <button type="submit" class="btn btn-primary" id="registerButton">Daftar</button>
                            @endif
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
    @if(auth()->user()->role == 'user' && auth()->user()->status == 'registerd' && is_null(Auth::user()->phone_verified_at))
        Swal.fire({
            title: "Verifikasi Nomor Telepon",
            text: "Nomor telepon Anda belum diverifikasi. Silakan verifikasi untuk melanjutkan.",
            icon: "warning",
            confirmButtonText: "Verifikasi Sekarang",
            dangerMode: true,
        }).then((willVerify) => {
            if (willVerify) {
                var userId = "{{ auth()->user()->id }}";
                if (userId) {
                    console.log("User ID:", userId);
                    window.location.href = "{{ route('register.verificationOtp.index', ['userId' => ':userId']) }}".replace(':userId', userId);
                } else {
                    console.error("User ID is missing.");
                }
            }
        });
    @elseif(is_null(Auth::user()->fullname))
        Swal.fire({
            title: "Lengkapi Profil",
            text: "Silakan lengkapi profil Anda terlebih dahulu.",
            icon: "warning",
            confirmButtonText: "Lengkapi Sekarang",
            dangerMode: true,
        }).then(() => {
            window.location.href = "{{ route('register.verificationOtp.update', ['userId' => auth()->user()->id]) }}";
        });
    @elseif(is_null(Auth::user()->email_verified_at))
        Swal.fire({
            title: "Verifikasi Email",
            text: "Silakan verifikasi email Anda terlebih dahulu.",
            icon: "warning",
            confirmButtonText: "Verifikasi Sekarang",
            dangerMode: true,
        }).then(() => {
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
