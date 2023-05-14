@extends('layouts.master')

@section('content')
@include('pages.master.employee.partials.employee-modal')
{{-- @include('pages.master.employee.partials.employee-modal-edit') --}}
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Karyawan</h3>
                {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Pengaturan</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Karyawan
                <button onclick="onCreate()" class="btn btn-sm btn-success shadow-sm float-end" id="addData"
                data-toggle="modal">
                <i class="fas fa-plus text-white-50"></i> Tambah Karyawan
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dataTable" id="table1">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $employee->nip }}
                        </td>
                        <td>
                            {{ $employee->name }}
                        </td>
                        <td>
                            {{ $employee->company->name ?? 'Data belum tersedia' }}
                        </td>
                        <td>
                            {{ $employee->departmen->name ?? 'Data belum tersedia' }}
                        </td>
                        <td>
                            {{ $employee->position->name ?? 'Data belum tersedia' }}
                        </td>
                        <td>
                            {{ $employee->status ?? 'Data belum tersedia' }}
                        </td>
                        <td class="flex flex-row justify-content-around">
                            @can('ubah karyawan')
                            <a href="javascript:void(0)" onclick="onEdit({{ $employee }})"
                            class="btn btn-sm btn-info">Ubah
                        </a>
                        @endcan
                        @can('hapus karyawan')
                        <a href="javascript:void(0)" onclick="onDelete({{ $employee }})"
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

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/nocss/litepicker.js"></script>
<script>
    const initialState = {
        employees: [],
    };

    let state = {
        ...initialState
    };

    $(document).ready(function() {
        $('.dataTable').DataTable();

        state.employees = {!! json_encode($employees) !!};
        setupSelect();
        // setupDateFilter();
        send();

    });

    function onCreate() {
        clearForm();
        $("#titleForm").html("Tambah Karyawan");


        // // Tampilkan form Data Personal
        // document.getElementById("personal-tab").classList.add("active");
        // document.getElementById("personal").classList.add("show", "active");

        // // Sembunyikan form Data Kepegawaian
        // document.getElementById("kepegawaian-tab").classList.remove("active");
        // document.getElementById("kepegawaian").classList.remove("show", "active");

        // Lakukan pengaturan tambahan sesuai kebutuhan

        onModalAction("formModal", "show");
    }

    function onEdit(data) {
        clearForm();

        // // Sembunyikan form Data Personal
        // document.getElementById("personal-tab").classList.remove("active");
        // document.getElementById("personal").classList.remove("show", "active");

        // // Tampilkan form Data Kepegawaian
        // document.getElementById("kepegawaian-tab").classList.add("active");
        // document.getElementById("kepegawaian").classList.add("show", "active");

        // document.getElementById("personal").style.display = "none";
        // document.getElementById("kepegawaian").style.display = "block";


        var idInput = document.getElementById('id');
        var tabKepegawaian = document.getElementById('tab-kepegawaian');

        // Atur nilai ID dari data.id ke elemen dengan ID "id"
        idInput.value = data.id;

        // Jika ID tidak ada
        if (!idInput) {
        // Sembunyikan tab kepegawaian
        console.log(idInput)
        tabKepegawaian.style.display = 'none';
        } else {
        // Tampilkan tab kepegawaian
        tabKepegawaian.style.display = 'block';
        }

        console.log(idInput)

        $("#id").val(data.id);
        $("#name").val(data.name);
        $("#company_id").val(data.company_id).trigger("change");
        $("#barge_id").val(data.barge_id).trigger("change");

        $("#titleForm").html("Ubah Karyawan" + data.id);

        // Mengatur #departmen menjadi nonaktif saat halaman dimuat
        $('#departmen').prop('disabled', true);

        // Mengatur peristiwa saat pilihan pada #company berubah
        $('#company').on('change', function() {
            var companyId = $(this).val();

            // Memuat departemen berdasarkan perusahaan yang dipilih
            $.ajax({
                url: 'employee/get-departmens/' + companyId,
                method: 'GET',
                success: function(response) {
                    // Menghapus opsi sebelumnya pada #departmen
                    $('#departmen').find('option').remove();

                    // Menambahkan opsi "-- Pilih Jabatan --"
                    $('#departmen').append('<option value="">-- Pilih Departemen --</option>');

                    // Menambahkan opsi departemen baru
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#departmen').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        // Mengaktifkan #departmen
                        $('#departmen').prop('disabled', false);
                    } else {
                        // Tidak ada departemen yang tersedia
                        $('#departmen').append('<option value="">Tidak ada departemen yang tersedia</option>');

                        // Menonaktifkan #departmen
                        $('#departmen').prop('disabled', true);
                    }
                },
                error: function() {
                    // Menampilkan pesan error jika terjadi masalah saat memuat departemen
                    console.log('Terjadi kesalahan saat memuat departemen.');
                }
            });
        });

        // Mengatur #position menjadi nonaktif saat halaman dimuat
        $('#position').prop('disabled', true);

        // Mengatur peristiwa saat pilihan pada #company berubah
        $('#departmen').on('change', function() {
            var departmenId = $(this).val();

            // Memuat departemen berdasarkan perusahaan yang dipilih
            $.ajax({
                url: 'employee/get-positions/' + departmenId,
                method: 'GET',
                success: function(response) {
                    // Menghapus opsi sebelumnya pada #departmen
                    $('#position').find('option').remove();

                    // Menambahkan opsi "-- Pilih Jabatan --"
                    $('#position').append('<option value="">-- Pilih Jabatan --</option>');

                    // Menambahkan opsi departemen baru
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#position').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        // Mengaktifkan #position
                        $('#position').prop('disabled', false);
                    } else {
                        // Tidak ada departemen yang tersedia
                        $('#position').append('<option value="">Tidak ada departemen yang tersedia</option>');

                        // Menonaktifkan #position
                        $('#position').prop('disabled', true);
                    }
                },
                error: function() {
                    // Menampilkan pesan error jika terjadi masalah saat memuat departemen
                    console.log('Terjadi kesalahan saat memuat departemen.');
                }
            });
        });

        onModalAction("formModal", "show");
    }

    function onDelete(data) {
        Swal.fire({
            title: 'Perhatian!!!',
            html: `Anda yakin ingin hapus data karyawan <h2><b> ${data.name} </b> ?</h2>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            onfirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('master.employee.delete') }}",
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
                url: "{{ route('master.employee.store') }}",
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
        $("#name").val("");
        $("#description").val("");
    }
</script>
@endsection
