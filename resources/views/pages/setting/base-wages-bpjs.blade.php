@extends('layouts.master')

@section('content')
@include('pages.setting.partials.base-wages-bpjs-modal')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dasar Upah BPJS</h3>
                {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Pengaturan</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Dasar Upah Bpjs</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Upah Bpjs
                {{-- <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-end" id="addData"
                        data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dasar Upah Bpjs
                    </button> --}}
            </div>
            <div class="card-body">
                <table class="table table-striped dataTable" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama BPJS</th>
                            <th>Nominal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($base_wages_bpjss as $base_wages_bpjs)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $base_wages_bpjs->name }}
                            </td>
                            <td>
                                {{ "Rp " . number_format($base_wages_bpjs->nominal, 0, ",", ".") }}
                            </td>
                            <td class="flex flex-row justify-content-around">
                                @can('ubah perhitungan bpjs')
                                <a href="javascript:void(0)" onclick="onEdit({{ $base_wages_bpjs }})"
                                    class="btn btn-sm btn-info">Ubah
                                </a>
                                @endcan
                                {{-- @can('hapus perhitungan bpjs')
                                            <a href="javascript:void(0)" onclick="onDelete({{ $base_wages_bpjs }})"
                                class="btn btn-sm btn-danger">Hapus
                                </a>
                                @endcan --}}
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
    $(document).ready(function () {
        $('.dataTable').DataTable();

        send();
    });

    function onCreate() {
        clearForm();
        $("#titleForm").html("Tambah Dasar Upah Bpjs");
        onModalAction("formModal", "show");
    }

    function onEdit(data) {
        clearForm();

        $("#id").val(data.id);
        $("#name").val(data.name);
        $("#nominal").val(data.nominal);

        $("#titleForm").html("Ubah Dasar Upah Bpjs");
        onModalAction("formModal", "show");

        var rupiah = document.getElementById("nominal");
        rupiah.addEventListener("keyup", function (e) {
            rupiah.value = formatRupiah(this.value, "Rp. ");
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    }

    function onDelete(data) {
        Swal.fire({
            title: 'Perhatian!!!',
            html: `Anda yakin ingin hapus data perhitungan bpjs <h2><b> ${data.name} </b> ?</h2>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            onfirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('setting.bpjsCalculation.delete') }}",
                    method: 'DELETE',
                    dataType: 'json',
                    data: {
                        id: data.id
                    },
                    success: function (responses) {
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
                    error: function (err) {
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
        $("#form").submit(function (e) {
            e.preventDefault();
            let fd = new FormData(this);

            $.ajax({
                url: "{{ route('setting.bpjsCalculation.store') }}",
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (responses) {

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
                error: function (err) {
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
        $("#name").val("");
        $("#description").val("");
    }

</script>
@endsection
