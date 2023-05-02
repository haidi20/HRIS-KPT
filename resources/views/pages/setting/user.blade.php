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
                    @can('lihat grup pengguna')
                        <a href="{{ route('setting.role.index') }}" class="btn btn-sm btn-primary shadow-sm float-right ml-2"
                            id="addData" data-toggle="modal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Grup Pengguna
                        </a>
                    @endcan
                    @can('tambah pengguna')
                        <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-right ml-2" id="addData"
                            data-toggle="modal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengguna
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table table-striped dataTable" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Grup Pengguna</th>
                                <th>Email</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->group_name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td class="flex flex-row justify-content-around ">
                                        @can('ubah pengguna')
                                            <a href="javascript:void(0)" onclick="onEdit({{ $user }})"
                                                class="btn btn-sm btn-primary">
                                                Ubah
                                            </a>
                                        @endcan
                                        @can('hapus pengguna')
                                            <a href="javascript:void(0)" onclick="onDelete({{ $user }})"
                                                class="btn btn-sm btn-danger">
                                                Hapus
                                            </a>
                                        @endcan
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

            send();
        });

        function onCreate() {
            clearForm();
            $("#titleForm").html("Tambah Pengguna");
            onModalAction("formModal", "show");
        }

        function onEdit(data) {
            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#role_id").val(data.role_id);

            $("#titleForm").html("Ubah Pengguna");
            onModalAction("formModal", "show");
        }

        function onDelete(id) {
            console.info(id);
        }

        function send() {
            $("#form").submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);

                console.info(fd);
            });
        }

        function setupSelect() {
            $(".select2").select2();
        }

        function clearForm() {
            setupSelect();
        }
    </script>
@endsection
