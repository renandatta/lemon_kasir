<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login - {{ env('APP_NAME') }}</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/css/pages/login/login-2.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
<div class="d-flex flex-column flex-root">
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
{{--                <a href="#" class="text-center pt-2">--}}
{{--                    <img src="{{ asset('assets/media/logos/logo.png') }}" class="max-h-75px" alt="" />--}}
{{--                </a>--}}
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    @include('tools._alert')
                    <div class="login-form login-signin py-11" id="form_login">
                        <form class="form" action="{{ route('login.proses') }}" method="post">
                            @csrf
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2>
                            </div>

                            <div class="form-group">
                                <label for="email" class="font-size-h6 font-weight-bolder text-dark">Username</label>
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" id="email" autocomplete="off" autofocus />
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label for="password" class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                </div>
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" id="password" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label class="checkbox checkbox-lg font-weight-bolder text-dark">
                                    <input type="checkbox" name="remember">
                                    <span></span>&nbsp; &nbsp;  Simpan Login
                                </label>
                            </div>

                            <div class="text-center pt-2">
                                <button type="submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #b1dced;">
            <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Lemon Kasir</h3>
                <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">
                </p>
            </div>
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url('{{ asset('assets/media/svg/illustrations/login-visual-2.svg') }}');"></div>
        </div>
    </div>
</div>
<script>
    let KTAppSettings = {
        breakpoints: { sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1200 },
        colors: {
            theme: {
                base: { white: "#ffffff", primary: "#1BC5BD", secondary: "#E5EAEE", success: "#1BC5BD", info: "#6993FF", warning: "#FFA800", danger: "#F64E60", light: "#F3F6F9", dark: "#212121" },
                light: { white: "#ffffff", primary: "#1BC5BD", secondary: "#ECF0F3", success: "#C9F7F5", info: "#E1E9FF", warning: "#FFF4DE", danger: "#FFE2E5", light: "#F3F6F9", dark: "#D6D6E0" },
                inverse: { white: "#ffffff", primary: "#ffffff", secondary: "#212121", success: "#ffffff", info: "#ffffff", warning: "#ffffff", danger: "#ffffff", light: "#464E5F", dark: "#ffffff" },
            },
            gray: { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" },
        },
        "font-family": "Poppins",
    };
</script>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.1.0') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.1.0') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js?v=7.1.0') }}"></script>
</body>
</html>
