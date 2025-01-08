<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="backend/images/login/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/fonts/login/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/login/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/login/main.css') }}">
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
                        Hallo Selamat Datang
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
                            Forgot
                        </span>
                        <a class="txt2" href="#">
                            Username / Password?
                        </a>
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
