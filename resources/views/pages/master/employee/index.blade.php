@extends('layouts.master')

@section('content')
@include('pages.master.employee.partials.employee-modal')
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
                            {{ $employee->company_name }}
                        </td>
                        <td>
                            {{ $employee->position_name }}
                        </td>
                        <td>
                            @if($employee->employee_status == "aktif")
                            <span class="text-success">AKTIF</span>
                            @else
                            <span class="text-danger">TIDAK AKTIF</span>
                            @endif
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
<link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/form-element-select.css') }}" rel="stylesheet" />"
<link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
"
<link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/datepicker3.css') }}" rel="stylesheet" />"
<link rel="stylesheet" href="{{ asset('assets-mazer/css/pages/daterangepicker.css') }}" rel="stylesheet" />"
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/nocss/litepicker.js"></script>
<script src="{{ asset('assets-mazer/extensions/backup/js/form-element-select.js') }}"></script>
<script src="{{ asset('assets-mazer/extensions/backup/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets-mazer/extensions/backup/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets-mazer/extensions/backup/js/daterangepicker.js') }}"></script>
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
        $("#kepegawaian-tab").hide();
        $("#salary-tab").hide();
        // $("#kepegawaian").hide();

        $('#birth_date').each(function () {
            $(this).datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                // viewMode: "months",
                // minViewMode: "months"
            });
            $(this).datepicker('clearDates');
        });
        onModalAction("formModal", "show");
    }

    function onEdit(data) {
        clearForm();

        $("#kepegawaian-tab").show();
        $("#salary-tab").show();
        // $("#kepegawaian").show();

        function formatEnterDate(dateString) {
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var date = new Date(dateString);
            var dayName = days[date.getDay()];
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var formattedDate = dayName + ', ' + day + '-' + month + '-' + year;
            return formattedDate;
        }

        $('#out_date').each(function () {
            $(this).datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                // viewMode: "months",
                // minViewMode: "months"
            });
           $(this).datepicker('setDate', new Date());
        });

        $('#contract_range input').each(function () {
            $(this).datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                // viewMode: "months",
                // minViewMode: "months"
            });
            $(this).datepicker('contract_range');
        });

        $("#employee_type_id").change(function() {
            var selectedValue = $(this).val();

            if (selectedValue === "1") {
                $("#contract_range_row").hide();
                $("#contract_start").val("");
                $("#contract_end").val("");
            }
            else if (selectedValue === "2") {
                $("#contract_range_row").show();
                $("#contract_start").val("");
                $("#contract_end").val("");
                $("#titleContactRange").html("Jangka Waktu Kontrak");
            }
            else if (selectedValue === "3") {
                $("#contract_range_row").show();
                $("#contract_start").val("");
                $("#contract_end").val("");
                $("#titleContactRange").html("Jangka Waktu Harian");
            } else {
                $("#contract_range_row").hide();
            }
        });

        $("#employee_status").change(function() {
            var employeeStatus = $(this).val();

            if (employeeStatus === "aktif") {
                $("#out_date_row").hide();
                $("#reason_row").hide();
                $("#reason").val("");
                $("#out_date").val("");
            }
            else if (employeeStatus === "tidak_aktif") {
                $("#out_date_row").show();
                $("#reason_row").show();
            }
        });

        // DATA PERSONAL
        $("#id").val(data.id);
        $("#nip").val(data.nip);
        $("#nik").val(data.nik);
        $("#name").val(data.name);
        $("#birth_place").val(data.birth_place);
        $("#birth_date").val(data.birth_date);
        $("#phone").val(data.phone);
        $("#religion").val(data.religion).trigger("change");
        $("#address").val(data.address);

        // DATA KEPEGAWAIAN
        $("#enter_date").val(formatEnterDate(data.enter_date));
        $("#npwp").val(data.npwp);
        $("#company_id").val(data.company_id).trigger("change");
        $("#position_id").val(data.position_id).trigger("change");
        $("#employee_type_id").val(data.employee_type_id).trigger("change");
        $("#contract_start").val(data.contract_start);
        $("#contract_end").val(data.contract_end);
        $("#latest_education").val(data.latest_education).trigger("change");
        $("#working_hour").val(data.working_hour).trigger("change");
        $("#married_status").val(data.married_status).trigger("change");

        $("#bpjs_tk").prop("checked", data.bpjs_tk === "Y");
        $("#bpjs_tk").attr("data-target", data.id);

        $("#bpjs_tk_pt").prop("checked", data.bpjs_tk_pt === "Y");
        $("#bpjs_tk_pt").attr("data-target", data.id);

        $("#bpjs_kes").prop("checked", data.bpjs_kes === "Y");
        $("#bpjs_kes").attr("data-target", data.id);

        $("#bpjs_kes_pt").prop("checked", data.bpjs_kes_pt === "Y");
        $("#bpjs_kes_pt").attr("data-target", data.id);

        $("#bpjs_training").prop("checked", data.bpjs_training === "Y");
        $("#bpjs_training").attr("data-target", data.id);

        $("#employee_status").val(data.employee_status).trigger("change");
        $("#reason").val(data.reason);
        $("#out_date").val(data.out_date);

        // DATA GAJI DAN REKENING
        $("#basic_salary").val(data.basic_salary);
        $("#rekening_number").val(data.rekening_number);
        $("#rekening_name").val(data.rekening_name);
        $("#bank_name").val(data.bank_name).trigger("change");
        $("#branch").val(data.branch);

        $("#titleForm").html("Ubah Karyawan");

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

        $('.bpjsTKCheck').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).attr('data-target');
            var _token = "{{ csrf_token() }}";

            var dataHide = $(this).attr('data-hide');


            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('master.employee.bpjsTK') }}",
                data: {
                    id: id,
                    mode: mode,
                    _token: _token
                },

                success: function(data) {
                    if (mode) {
                        $(dataHide).css('display', 'block');
                        console.log("Data Berhasil Diaktifkan");
                    } else {
                        $(dataHide).css("display", "none");
                        console.log("Data Berhasil Dinonaktifkan");
                    }
                }
            });
        });

        $('.bpjsTKPTCheck').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).attr('data-target');
            var _token = "{{ csrf_token() }}";

            var dataHide = $(this).attr('data-hide');


            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('master.employee.bpjsTKPT') }}",
                data: {
                    id: id,
                    mode: mode,
                    _token: _token
                },

                success: function(data) {
                    if (mode) {
                        $(dataHide).css('display', 'block');
                        console.log("Data Berhasil Diaktifkan");
                    } else {
                        $(dataHide).css("display", "none");
                        console.log("Data Berhasil Dinonaktifkan");
                    }
                }
            });
        });

        $('.bpjsKESCheck').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).attr('data-target');
            var _token = "{{ csrf_token() }}";

            var dataHide = $(this).attr('data-hide');


            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('master.employee.bpjsKES') }}",
                data: {
                    id: id,
                    mode: mode,
                    _token: _token
                },

                success: function(data) {
                    if (mode) {
                        $(dataHide).css('display', 'block');
                        console.log("Data Berhasil Diaktifkan");
                    } else {
                        $(dataHide).css("display", "none");
                        console.log("Data Berhasil Dinonaktifkan");
                    }
                }
            });
        });

        $('.bpjsKESPTCheck').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).attr('data-target');
            var _token = "{{ csrf_token() }}";

            var dataHide = $(this).attr('data-hide');


            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('master.employee.bpjsKESPT') }}",
                data: {
                    id: id,
                    mode: mode,
                    _token: _token
                },

                success: function(data) {
                    if (mode) {
                        $(dataHide).css('display', 'block');
                        console.log("Data Berhasil Diaktifkan");
                    } else {
                        $(dataHide).css("display", "none");
                        console.log("Data Berhasil Dinonaktifkan");
                    }
                }
            });
        });

        $('.bpjsTRAININGCheck').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).attr('data-target');
            var _token = "{{ csrf_token() }}";

            var dataHide = $(this).attr('data-hide');


            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('master.employee.bpjsTRAINING') }}",
                data: {
                    id: id,
                    mode: mode,
                    _token: _token
                },

                success: function(data) {
                    if (mode) {
                        $(dataHide).css('display', 'block');
                        console.log("Data Berhasil Diaktifkan");
                    } else {
                        $(dataHide).css("display", "none");
                        console.log("Data Berhasil Dinonaktifkan");
                    }
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
            e.preventDefault(); // Batalkan tindakan submit default

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
        $("#nip").val("");
        $("#nik").val("");
        $("#name").val("");
        $("#birth_place").val("");
        $("#birth_date").val("");
        $("#phone").val("");
        $("#religion").val("").trigger("change");
        $("#address").val("");
    }
</script>
@endsection
