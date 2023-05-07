<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS - KPT</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/main/app.css')}}">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/auth.css')}}">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/shared/iconly.css')}}">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/fontawesome.css')}}">
    <style>
        .form-group[class*="has-icon-"] .form-control-icon i,
        .form-group[class*="has-icon-"] .form-control-icon svg {
            line-height: 1 !important;
        }
    </style>
</head>

<body style="background-color: var(--bs-body-bg) !important;">
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
</body>

</html>
