@extends('layouts.master')

@section('content')
    @include('pages.setting.partials.role-permission-modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Hak Akses - {{ $nameGroupUser }}</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('setting.role.index') }}">Grup Pengguna</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hak Akses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Data
                    <a href="{{ route('setting.permission.index') }}" class="btn btn-sm btn-success shadow-sm float-right"
                        id="addData" data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Hak Akses
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped dataTable" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($features as $feature)
                                <tr>
                                    <td>
                                        {{ $feature->title }}
                                    </td>
                                    <td>
                                        {{ $feature->description }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="onEdit({{ $feature->id }})"
                                            class="btn btn-sm btn-primary">
                                            Ubah
                                        </a>
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
    {{-- <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();

            findData();
            send();
        });

        function onEdit(id) {
            console.info(id);
            $("#titleForm").html("Ubah Hak Akses");
            $("#formModal").modal("show");
        }

        function findData() {
            $.ajax({
                url: "{{ route('setting.rolePermission.show', ['roleId' => $roleId]) }}",
                method: 'GET',
                data: {
                    role_id: "{{ $roleId }}"
                },
                beforeSend: function() {
                    // empty view
                },
                success: function(responses) {
                    console.info(responses);
                },
                error: function(err) {}
            });
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
