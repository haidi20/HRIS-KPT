@extends('layouts.master')

@section('content')
    @include('pages.master.job.partials.modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pekerjaan</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="#">Pengaturan</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Pekerjaan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
               <div class="card-header">
                    <span class="fs-4 fw-bold">Data Jenis Pekerjaan</span>
                    <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-end" id="addData" data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jenis Pekerjaan
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped dataTable" id="table1">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>
                                        {{ $job->code }}
                                    </td>
                                    <td>
                                        {{ $job->name }}
                                    </td>
                                    <td>
                                        {{ $job->description }}
                                    </td>
                                    <td>
                                        @can('ubah kategori job')
                                            <a href="javascript:void(0)" onclick="onEdit({{ $job }})"
                                                class="btn btn-sm btn-info">Ubah
                                            </a>
                                        @endcan
                                        @can('hapus kategori job')
                                            <a href="javascript:void(0)" onclick="onDelete({{ $job }})"
                                                class="btn btn-sm btn-danger">Hapus
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
    {{-- <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script> --}}

    <script>
        const initialState = {
            jobs: [],
        };

        let state = {
            ...initialState
        };

        $(document).ready(function() {
            $('.dataTable').DataTable();

            state.jobs = {!! json_encode($jobs) !!};
            send();
        });

        function onCreate() {
            clearForm();
            $("#titleForm").html("Tambah Jenis Pekerjaan");
            onModalAction("formModal", "show");
        }

        function onEdit(data) {
            clearForm();

            $("#id").val(data.id);
            $("#code").val(data.code);
            $("#name").val(data.name);
            $("#description").val(data.description);

            $("#titleForm").html("Ubah Jenis Pekerjaan");
            onModalAction("formModal", "show");
        }

        function onDelete(data) {
            Swal.fire({
                title: 'Perhatian!!!',
                html: `Anda yakin ingin hapus data job <h2><b> ${data.name} </b> ?</h2>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                onfirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('master.job.delete') }}",
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

        function send() {
            $("#form").submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);

                $.ajax({
                    url: "{{ route('master.job.store') }}",
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

        function clearForm() {
            $("#id").val("");
            $("#code").val("");
            $("#name").val("");
            $("#description").val("");
        }
    </script>
@endsection
