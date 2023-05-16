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
                <div class="row">
                    <div class="col-12 d-flex align-items-center">
                        <h5>Filter berdasarkan : </h5>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="jabatanFilter" class="col-form-label">Jabatan :</label>
                        <div style="width: 100%;">
                            <select name="jabatanFilter" id="jabatanFilter" class="form-control select2"
                                style="width: 100%;">
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($positions as $position)
                                <option value="{{ $position->name }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6 form-group">
                        <label for="locationFilter" class="col-form-label">Lokasi :</label>
                        <div style="width: 100%;">
                            <select name="locationFilter" id="locationFilter" class="form-control select2"
                                style="width: 100%;">
                                <option value="">-- Pilih Lokasi Karyawan --</option>
                                @foreach ($locations as $location)
                                <option value="{{ $location->name }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-striped dataTable" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Perusahaan</th>
                            <th>Jabatan</th>
                            <th width="15%">Lokasi</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $employee->nip }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->company_name }}</td>
                            <td>{{ $employee->position_name }}</td>
                            <td>{{ $employee->location_name }}</td>
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
                                    class="btn btn-sm btn-info">Ubah</a>
                                @endcan
                                @can('hapus karyawan')
                                <a href="javascript:void(0)" onclick="onDelete({{ $employee }})"
                                    class="btn btn-sm btn-danger">Hapus</a>
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

    // SETUP FILTER POSITION
    $(document).ready(function () {
        var table = $('.dataTable').DataTable();

        $('#jabatanFilter').select2();

        $('#jabatanFilter').on('change', function() {
            var selectedJabatan = $(this).val();
            table.column(4).search(selectedJabatan).draw();
        });
    })

    // SETUP FILTER LOCATION
    $(document).ready(function () {
        var table = $('.dataTable').DataTable();

        $('#locationFilter').select2();

        $('#locationFilter').on('change', function() {
            var selectedLocation = $(this).val();
            table.column(5).search(selectedLocation).draw();
        });
    })

    function onCreate() {
        clearForm();
        $("#titleForm").html("Tambah Karyawan");
        $("#kepegawaian-tab").hide();
        $("#salary-tab").hide();
        $("#finger-tab").hide();
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

        $("#photo").change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#photoPreview").html('<img src="' + e.target.result + '" alt="Foto" width="100%">');
            };

            reader.readAsDataURL(file);
        });
        onModalAction("formModal", "show");
    }

    function onEdit(data) {
        clearForm();

        // MEMUNCULKAN TAB
        $("#kepegawaian-tab").show();
        $("#salary-tab").show();
        $("#finger-tab").show();

        // SETUP FORMAT UNTUK TANGGAL MASUK
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

        // SETUP FORMAT UNTUK TANGGAL KELUAR
        $('#out_date').each(function () {
            $(this).datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                // viewMode: "months",
                // minViewMode: "months"
            });
            $(this).datepicker('setDate', new Date());
        });

        // SETUP FORMAT UNTUK KONTRAK
        $('#contract_range input').each(function () {
            $(this).datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                // viewMode: "months",
                // minViewMode: "months"
            });
            $(this).datepicker('contract_range');
        });

        // SETUP KONDISI UNTUK JENIS KARYAWAN
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

        // SETUP KONDISI UNTUK STATUS KARYAWAN
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

        // EDIT VALUE
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
        $("#photo").change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#photoPreview").html('<img src="' + e.target.result + '" alt="Foto" width="100%">');
            };

            reader.readAsDataURL(file);
        });
        $("#photoPreviewReady").show();
        var photoUrl = "{{ Storage::url('') }}" + data.photo;

        var imageElement = document.createElement("img");
        imageElement.src = photoUrl;
        imageElement.alt = "Employee Photo";
        imageElement.style.width = "100%";

        var photoPreviewReady = document.getElementById("photoPreviewReady");
        photoPreviewReady.innerHTML = "";
        photoPreviewReady.appendChild(imageElement);

        // DATA KEPEGAWAIAN
        $("#enter_date").val(formatEnterDate(data.enter_date));
        $("#npwp").val(data.npwp);
        $("#company_id").val(data.company_id).trigger("change");
        $("#position_id").val(data.position_id).trigger("change");
        $("#location_id").val(data.location_id).trigger("change");
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

        // CHECK SLIDER CONDITION
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
        $("#photo").val("");
        $("#photoPreview").val("");
        $("#photoPreviewReady").hide();
    }
</script>
@endsection
