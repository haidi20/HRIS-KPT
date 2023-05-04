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
                        <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-end ml-2" id="addData"
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
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        {{ $role->name }}
                                    </td>
                                    <td class="flex flex-row justify-between">
                                        @can('detail grup pengguna')
                                            <a href="{{ route('setting.rolePermission.index', ['roleId' => $role->id]) }}"
                                                class="btn btn-sm btn-primary">
                                                Detail
                                            </a>
                                        @endcan
                                        @can('ubah grup pengguna')
                                            <a href="javascript:void(0)" onclick="onEdit({{ $role }})"
                                                class="btn btn-sm btn-info">Ubah
                                            </a>
                                        @endcan
                                        @can('hapus grup pengguna')
                                            <a href="javascript:void(0)" onclick="onDelete({{ $role }})"
                                                class="btn btn-sm btn-danger">Hapus
                                            </a>
                                        </td>
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
            onModalAction("formModal", "show");
        }

        function onDetail(id) {
            onModalAction("formDetailModal", "show");
        }

        function onEdit(data) {
            clearForm();
            $("#id").val(data.id);
            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#role_id").val(data.role_id).trigger("change");

            $("#titleForm").html("Ubah Pengguna");
            onModalAction("formModal", "show");
        }

        function send() {
            $("#form").submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);

                $.ajax({
                    url: "{{ route('setting.role.store') }}",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(responses) {

                        // console.info(responses);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        if (responses.success == true) {
                            Toast.fire({
                                icon: 'success',
                                title: responses.message
                            });

                            window.location.reload();
                        }
                    },
                    error: function(err) {
                        console.log(err.responseJSON.message);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'error',
                            title: err.responseJSON.message
                        });
                    }
                });
            });
        }

        function onDelete(data) {
            Swal.fire({
                title: 'Perhatian!!!',
                html: `Anda yakin ingin hapus data pengguna <h2><b> ${data.name} </b> ?</h2>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                onfirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('setting.role.delete') }}",
                        method: 'DELETE',
                        dataType: 'json',
                        data: {
                            id: data.id
                        },
                        success: function(responses) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });
                            if (responses.success == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: responses.message
                                });

                                window.location.reload();
                            }
                        },
                        error: function(err) {
                            // console.log(err.responseJSON.message);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'error',
                                title: err.responseJSON.message
                            });
                        }
                    });
                }
            });
        }

        function clearForm() {
            //
        }
    </script>
@endsection
