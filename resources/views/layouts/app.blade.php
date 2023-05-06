<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS - KPT</title>
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/main/app.css')}}">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/auth.css')}}">
    <link rel="shortcut icon" href="{{ asset('assets-mazer/images/logo/favicon.ico')}}" type="image/x-icon">

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
    <script src="{{ asset('assets-mazer/js/extensions/jquery.js' )}}"></script>
    <script src="{{ asset('assets-mazer/vendors/perfect-scrollbar/perfect-scrollbar.min.js' )}}"></script>
    <script src="{{ asset('assets-mazer/js/bootstrap.bundle.min.js' )}}"></script>

    <script src="{{ asset('assets-mazer/vendors/apexcharts/apexcharts.js' )}}"></script>
    <script src="{{ asset('assets-mazer/js/pages/dashboard.js' )}}"></script>

    <script src="{{ asset('assets-mazer/js/pages/horizontal-layout.js' )}}"></script>
    <script src="{{ asset('assets-mazer/js/mazer.js' )}}"></script>

    <script type="text/javascript">
        var timeDisplay = document.getElementById("time");


    function refreshTime() {
      var dateString = new Date().toLocaleString();
      var formattedString = dateString.replace(", ", " - ");
      timeDisplay.innerHTML = formattedString;
    }

    setInterval(refreshTime, 1000);
    </script>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
      // toggle the type attribute
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      // toggle the eye icon
      this.classList.toggle('bi-eye');
      this.classList.toggle("bi-eye-slash");
    });
    </script>
</body>

</html>
