@extends('layouts.master')

@section('content')
@include('pages.master.departmen.partials.modal')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Departemen</h3>
                {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Karyawan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Departemen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <span class="fs-4 fw-bold">Data Departemen</span>
                <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-end" id="addData"
                data-toggle="modal">
                <i class="fas fa-plus text-white-50"></i> Tambah Departemen
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dataTable" id="table1">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Perusahaan</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departmens as $departmen)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $departmen->company->name }}
                        </td>
                        <td>
                            {{ $departmen->code }}
                        </td>
                        <td>
                            {{ $departmen->name }}
                        </td>
                        <td>
                            {{ $departmen->description }}
                        </td>
                        <td>
                            @can('ubah departemen')
                            <a href="javascript:void(0)" onclick="onEdit({{ $departmen }})"
                            class="btn btn-sm btn-info">Ubah
                        </a>
                        @endcan
                        @can('hapus departemen')
                        <a href="javascript:void(0)" onclick="onDelete({{ $departmen }})"
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
        positions: [],
    };

    let state = {
        ...initialState
    };

    $(document).ready(function() {
        $('.dataTable').DataTable();

        state.positions = {!! json_encode($departmens) !!};
        setupSelect();
        setInitialCode();
        send();
    });

    function onCreate() {
        clearForm();

        $("#titleForm").html("Tambah Departemen");

        $("#code-new").show();
        $("#code-last").hide();

        onModalAction("formModal", "show");
    }

    function onEdit(data) {
        clearForm();

        $("#id").val(data.id);
        $("#company_id").val(data.company_id).trigger("change");
        $("#name").val(data.name);
        $("#code-last").val(data.code);
        $("#code-last").show();
        $("#code-new").hide();
        $("#description").val(data.description);

        $("#titleForm").html("Ubah Departemen");
        onModalAction("formModal", "show");
    }

    function onDelete(data) {
        Swal.fire({
            title: 'Perhatian!!!',
            html: `Anda yakin ingin hapus data departemen <h2><b> ${data.name} </b> ?</h2>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            onfirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('master.departmen.delete') }}",
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
                url: "{{ route('master.departmen.store') }}",
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

    function setupSelect() {
        $(".select2").select2();
    }

    function clearForm() {
        $("#id").val("");
        $("#code").val("");
        $("#name").val("");
        $("#description").val("");
        $("#company_id").val("");
    }

    function setInitialCode(companyId) {
        var codeInput = document.getElementById("code-new");
        var initialCode = "";

        if (companyId == 1) {
            initialCode = "PT-";
        } else if (companyId == 2) {
            initialCode = "CV-";
        }

        // Mengirim permintaan AJAX untuk mendapatkan code terakhir dari server
        fetch('departmen/get-last-code?company_id=' + companyId)
        .then(response => response.json())
        .then(data => {
            // Mendapatkan code terakhir dari respons
            var lastCode = data.lastCode;

            if (lastCode) { // Jika data terisi, tampilkan langsung pada input #code
                codeInput.value = lastCode;
            } else { // Jika data kosong, buatkan kode baru
                // Mengambil nomor dari code terakhir
                var lastCodeNumber = parseInt(lastCode.match(/\d+$/)[0]);

                // Increment nomor
                var nextCodeNumber = lastCodeNumber + 1;

                // Membentuk code baru dengan nomor yang diincrement
                var nextCode = initialCode + nextCodeNumber;

                // Memasukkan code baru ke dalam input
                codeInput.value = nextCode;
            }
        })
        .catch(error => console.log(error));
    }
</script>
@endsection
