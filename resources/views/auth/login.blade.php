<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Login</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">

    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/pace/pace.css') }}" rel="stylesheet" type="text/css" />


    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />


    <link href="../../" rel="stylesheet">
    <link href="../../assets/css/custom.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/neptune.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/neptune.png') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <img src="{{ asset('landing/images/working-girl.png') }}" height="700" alt="working girl"
                style="display: block; margin: 0 300px 0 0; padding: 0;">
        </div>

        <div class="app-auth-container">

            <div class="logo mb-4">
                <a href="index.html">SPK Koperasi</a>
            </div>

            @if (session()->has('error'))
                <div class="alert alert-danger alert-style-light absolute " role="alert" style="z-index: 1000;">
                    <span class="alert-icon-wrap mb-3">
                        {{ session('error') }}
                    </span>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            <form class="w-100" action="{{ route('login.action') }}" method="POST" autocomplete="off">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control m-b-md" id="email"
                        aria-describedby="email" placeholder="Masukan email anda...">

                    <label for="signInPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password"
                        aria-describedby="password" placeholder="Masukan password anda...">
                </div>

                <div class="auth-submit">
                    <button class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="divider"></div>
            {{-- <div class="auth-alts">
                <a href="#" class="auth-alts-google"></a>
                <a href="#" class="auth-alts-facebook"></a>
                <a href="#" class="auth-alts-twitter"></a>
            </div> --}}
        </div>
    </div>

    <!-- Javascripts -->
    <script src="../../assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../../assets/plugins/pace/pace.min.js"></script>
    <script src="../../assets/js/main.min.js"></script>
    <script src="../../assets/js/custom.js"></script>
</body>

</html>
