<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Login | SMB LIST PO IMX - Minimal Admin &amp; Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin &amp; Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('cms/assets/img/logo.png') }}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('cms/assets/preloader.min.css') }}" type="text/css">

    <!-- Bootstrap Css -->
    <link href="{{ asset('cms/assets/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('cms/assets/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('cms/assets/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <script src="{{ asset('cms/assets/sweetalert2.js') }}"></script>

</head>

<body class="pace-done ">
    <div class="pace pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
            style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    <!-- <body data-layout="horizontal"> -->
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="{{ asset('cms/assets/img/logo.png') }}" alt="" height="80">
                                        <span class="logo-txt"></span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Welcome Back !</h5>
                                        <p class="text-muted mt-2">SMB IMEX LIST PO IMX.</p>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Enter email" value={{ old('email') }}>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Password</label>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="">
                                                        <a href="{{ route('password.request') }}"
                                                            class="text-muted">Forgot password?</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Enter password" aria-label="Password"
                                                    aria-describedby="password-addon">
                                                <button class="btn btn-light shadow-none ms-0" type="button"
                                                    id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remember_me"
                                                        name="remember">
                                                    <label class="form-check-label" for="remember_me">
                                                        Remember me
                                                    </label>

                                                </div>
                                            </div>

                                            @if ($errors->any())
                                                <div id="error-messages" style="display: none;">
                                                    @foreach ($errors->all() as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if (session('success'))
                                                <div id="success-messages" style="display: none;">
                                                    <p>{{ session('success') }}</p>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">Log In</button>
                                        </div>
                                    </form>

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Don't have an account ? <a href="/register"
                                                class="text-primary fw-semibold"> Signup now </a> </p>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> SMB IMEX LIST PO IMX <br>Crafted with <i
                                            class="mdi mdi-heart text-danger"></i> by SMB IMEX LIST PO IMX
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-primary"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide"
                                        data-bs-ride="carousel">
                                        <div
                                            class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="0" class="active" aria-current="true"
                                                aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                        imposing change
                                                        on myself. It's a lot more progressing fun than looking back.
                                                        That's why
                                                        I ultricies enim
                                                        at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="https://themesbrand.com/minia/layouts/assets/images/users/avatar-1.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Richard Drews
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Web Designer</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                        free ourselves by widening our circle of compassion to embrace
                                                        all living
                                                        creatures and
                                                        the whole of quis consectetur nunc sit amet semper justo. nature
                                                        and its beauty.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="https://themesbrand.com/minia/layouts/assets/images/users/avatar-2.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Rosanna French
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Web Developer</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('cms/assets/jquery.min.js') }}"></script>
    <script src="{{ asset('cms/assets/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cms/assets/metisMenu.min.js') }}"></script>
    <script src="{{ asset('cms/assets/simplebar.min.js') }}"></script>
    <script src="{{ asset('cms/assets/waves.min.js') }}"></script>
    <script src="{{ asset('cms/assets/feather.min.js') }}"></script>
    <script src="{{ asset('cms/assets/pace.min.js') }}"></script>
    <script src="{{ asset('cms/assets/pass-addon.init.js') }}"></script>
    {{-- <script src="https://themesbrand.com/minia/layouts/assets/libs/node-waves/waves.min.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for error messages
            let errorMessages = document.getElementById('error-messages');
            if (errorMessages) {
                let messages = Array.from(errorMessages.getElementsByTagName('p')).map(p => p.innerText).join(
                    '<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: messages,
                });
            }

            // Check for success messages
            let successMessages = document.getElementById('success-messages');
            if (successMessages) {
                let messages = Array.from(successMessages.getElementsByTagName('p')).map(p => p.innerText).join(
                    '<br>');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: messages,
                });
            }
        });
    </script>

</body>

</html>
