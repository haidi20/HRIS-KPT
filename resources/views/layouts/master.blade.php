<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HRIS - KPT</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets-mazer/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-tailwind.css') }}">
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('custom/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @yield('style')
</head>

<body class="full-height">
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app" class="full-height">
        @include('layouts.sidebar')
        <div id="main" class='layout-navbar full-height'>
            @include('layouts.header')
            <div id="main-content" class="pt-0">
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="logout" tabindex="-1" aria-labelledby="logout" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logout">Logout</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah anda yakin ingin keluar?
                    </p>
                </div>
                <div class="modal-footer">
                    {{-- <a href="/logout" class="btn btn-danger ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fas fa-door-open"></i>&nbsp; Keluar</span>
                    </a> --}}
                    <a href="{{ route('logout') }}" class="btn btn-danger ml-1"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fas fa-door-open"></i>&nbsp; Keluar</span>
                    </a>
                    <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none">
                        @csrf
                        <button type="submit" class="">Logout</button>
                    </form>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- <script src="{{ asset('assets/compiled/js/app-mazer.js') }}"></script> --}}
    {{-- bootstrap.js not found --}}
    {{-- <script src="{{ asset('assets/compiled/js/bootstrap.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/compiled/js/mazer.js') }}"></script> --}}
    <script src="{{ asset('assets-mazer/js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap.js') }}" defer></script> --}}
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    @isset($vue)
        <script src="{{ asset('js/app.js') }}"></script>
    @endisset
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function onModalAction(id, type) {
            const myModal = new bootstrap.Modal(document.getElementById(id), {});

            if (type == "show") {
                myModal.show();
            } else {
                myModal.hide();
            }
        }
    </script>

    @yield('script')

</body>

</html>
