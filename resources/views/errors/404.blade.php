<html lang="en"><head>
        
    <meta charset="utf-8">
    <title>404 Not Found | SMB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin &amp; Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    @include('includes.styles')

</head>

<body class="pace-done "><div class="pace pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
<div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>

<!-- <body data-layout="horizontal"> -->

    <div class="my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-1 fw-semibold">4<span class="text-primary mx-2">0</span>4</h1>
                        <h4 class="text-uppercase">Not Found</h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div>
                        <img src="{{ asset('cms/assets/img/error-img.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="mt-5 text-center">
                        <a class="btn btn-primary waves-effect waves-light" href="/dashboard">Back to Dashboard</a>
                    </div>
                    <div class="mt-5 text-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end content -->
</body>
</html>