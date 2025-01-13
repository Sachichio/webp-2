<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('backend/images/login/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/fonts/login/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/main.css') }}">
    <style>
        .example-box {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .example-box p {
            font-size: 16px;
            margin: 5px 0;
        }
        .example-box h3 {
        font-size: 24px; /* Ukuran font untuk judul */
        font-weight: bold; /* Menebalkan teks */
        color: #333; /* Warna teks */
        margin-bottom: 10px; /* Memberikan jarak bawah agar tidak terlalu rapat */
        }

        .example-box .label {
        font-weight: bold;
        }

    </style>
</head>
<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="backend/images/login/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <span class="login100-form-title">
                        Halo, Selamat Datang!
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email or username is required">
                        <input class="input100" type="text" name="login" required placeholder="Email atau Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" required placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    @if ($errors->any())
                        <div class="error-message text-center p-t-12">
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Created by
                        </span>
                        <a class="txt2" target="_blank" href="https://github.com/Sachichio/webp-2">
                            Kelompok 3
                        </a>
                    </div>

                    <!-- Example Box Below "Forgot Username / Password?" -->
                    <div class="example-box">
                        <h3><span class="label">Example</span></h3>
                        <p><span class="label">Username:</span> joko.widodo@gmail.com</p>
                        <p><span class="label">Password:</span> 00000000</p>
                    </div>

                    <div class="text-center p-t-136">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/vendor/login/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/login/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('backend/vendor/login/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/login/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/login/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });
    </script>
    <script src="{{ asset('backend/js/login/main.js') }}"></script>

</body>
</html>
