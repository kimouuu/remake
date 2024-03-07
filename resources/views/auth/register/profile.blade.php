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
<section id="form-and-scrolling-components">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <form action="{{ route('register.verificationOtp.verified', $user->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="fullname">Full Name: </label>
                                    <input id="fullname" type="text" name="fullname" placeholder="Full Name"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email: </label>
                                    <input id="email" type="email" name="email" placeholder="Email"
                                        class="form-control" required>
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
                                    <input id="date_birth" type="date" name="date_birth" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address: </label>
                                    <input id="address" type="text" name="address" placeholder="Address"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="province">Province: </label>
                                    <input id="province" type="text" name="province" placeholder="Province"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="city">City: </label>
                                    <input id="city" type="text" name="city" placeholder="City"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="district">District: </label>
                                    <input id="district" type="text" name="district" placeholder="District"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal Code: </label>
                                    <input id="postal_code" type="text" name="postal_code" placeholder="Postal Code"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-check"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Include your script files here -->
<script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
<script src="{{ asset('mazer/assets/compiled/js/app-dark.js') }}"></script>
<script src="{{ asset('mazer/assets/compiled/js/init-scripts.js') }}"></script>
<!-- Add any additional scripts if needed -->
</body>

</html>
