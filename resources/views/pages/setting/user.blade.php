@extends('layouts.master')

@section('content')
    @include('pages.setting.partials.user-modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pengguna</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('setting.permission.index') }}">Fitur</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Data
                    <a href="{{ route('setting.role.index') }}" class="btn btn-sm btn-primary shadow-sm float-right ml-2"
                        id="addData" data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Menu Grup Pengguna
                    </a>
                    <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-right ml-2" id="addData"
                        data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-striped dataTable" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();

            _setupSelect();
            _send();
        });

        function onCreate() {
            _clearForm();
            $("#titleForm").html("Tambah Pengguna");
            $("#formModal").modal("show");
        }

        function _send() {
            $("#form").submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);

                console.info(fd);
            });
        }

        function _setupSelect() {
            let choices = document.querySelectorAll(".choices")
            let initChoice
            for (let i = 0; i < choices.length; i++) {
                if (choices[i].classList.contains("multiple-remove")) {
                    initChoice = new Choices(choices[i], {
                        delimiter: ",",
                        editItems: true,
                        maxItemCount: -1,
                        removeItemButton: true,
                    })
                } else {
                    initChoice = new Choices(choices[i])
                }
            }

        }

        function _clearForm() {
            //
        }
    </script>
@endsection
