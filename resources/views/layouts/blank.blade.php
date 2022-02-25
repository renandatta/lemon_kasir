<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link href="{{ asset('assets/css/blank_page.css') }}" rel="stylesheet" type="text/css" />
    <style>

    </style>
    @stack('styles')
</head>
<body>

@yield('content')

@stack('scripts')

</body>
</html>
