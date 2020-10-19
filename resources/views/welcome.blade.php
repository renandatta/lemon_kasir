<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }}</title>
        <meta name="title"                     content="Lemon Kasir" />
        <meta name="description"               content="Aplikasi Kasir Minimalis dan Gratis" />
        <meta property="og:image"              content="{{ asset('lemon.png') }}">
        <meta property="og:image:type"         content="image/png">
        <meta property="og:url"                content="{{ route('/') }}" />
        <meta property="og:type"               content="article" />
        <meta property="og:title"              content="Lemon Kasir" />
        <meta property="og:description"        content="Aplikasi Kasir Minimalis dan Gratis" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body class=" page-loading">
        <div class="row h-100 justify-content-center">
            <div class="col-md-4 col-8 my-auto">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('lemon.png') }}" alt="" height="50px">
                            <h3>Lemon Kasir</h3>
                            <i class="fa fa-spinner fa-spin fa-3x text-dark my-5"></i>
                        </div>
                    </div>
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
        <script>
            @auth
                @if(!empty(\Illuminate\Support\Facades\Auth::user()->user_profil))
                setTimeout(function () {
                    window.location.href = "{{ route('kasir.dashboard') }}";
                }, 500);
                @else
                setTimeout(function () {
                    window.location.href = "{{ route('home.dashboard') }}";
                }, 500);
                @endif
            @endauth

            @guest
            setTimeout(function () {
                window.location.href = "{{ route('login') }}";
            }, 500);
            @endguest
        </script>
    </body>
</html>
