@extends('layouts.master')

@section('content')
    @include('pages.setting.partials.role-modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Grup User</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('setting.permission.index') }}">Fitur</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Grup User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Data
                    @can('tambah grup pengguna')
                        <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-right ml-2" id="addData"
                            data-toggle="modal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Grup User
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table table-striped dataTable" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th width="10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        {{ $role->name }}
                                    </td>
                                    <td>
                                        @can('detail grup pengguna')
                                            <a href="{{ route('setting.rolePermission.index', ['roleId' => $role->id]) }}"
                                                class="btn btn-sm btn-primary">
                                                Detail
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

@section('script')
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();

            send();
        });

        function onCreate() {
            clearForm();
            $("#titleForm").html("Tambah Grup Pengguna");
            $("#formModal").modal("show");
        }

        function onDetail(id) {
            $("#formDetailModal").modal("show");
        }

        function send() {
            $("#form").submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);

                console.info(fd);
            });
        }

        function clearForm() {
            //
        }
    </script>
@endsection
