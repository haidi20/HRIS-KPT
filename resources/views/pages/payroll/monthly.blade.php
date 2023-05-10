@extends('layouts.master')

@section('content')
    @include('pages.master.position.partials.modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Penggajian Bulanan</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="#">Pengaturan</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Penggajian Bulanan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicInput">Pilih Bulan</label>
                                <input type="month" class="form-control" id="month_filter" autocomplete="off"
                                    value="{{ $monthNow }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="employees">Pilih karyawan</label>
                                <select name="employees" id="employees" class="form-control select2" style="width: 100%;">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" style="align-self: center;">
                            <button type="button" onclick="onFilter()" class="btn btn-sm btn-success mt-2 ml-4 mt-md-0">
                                Kirim
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " id="information-tab" data-bs-toggle="tab" href="#information"
                                role="tab" aria-controls="information" aria-selected="true">Informasi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " id="salary-tab" data-bs-toggle="tab" href="#salary" role="tab"
                                aria-controls="salary" aria-selected="true">Perhitungan Gaji</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " id="attendance-tab" data-bs-toggle="tab" href="#attendance" role="tab"
                                aria-controls="attendance" aria-selected="true">Absensi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " id="bpjs-tab" data-bs-toggle="tab" href="#bpjs" role="tab"
                                aria-controls="bpjs" aria-selected="true">Perhitungan BPJS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pph21-tab" data-bs-toggle="tab" href="#pph21" role="tab"
                                aria-controls="pph21" aria-selected="true">Perhitungan Pajak Penghasilan (PPH 21)</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show " id="information" role="tabpanel">
                            @include('pages.payroll.partials.information')
                        </div>
                        <div class="tab-pane fade show " id="salary" role="tabpanel">
                            @include('pages.payroll.partials.salary')
                        </div>
                        <div class="tab-pane fade show " id="attendance" role="tabpanel">
                            @include('pages.payroll.partials.attendance')
                        </div>
                        <div class="tab-pane fade show " id="bpjs" role="tabpanel">
                            @include('pages.payroll.partials.bpjs')
                        </div>
                        <div class="tab-pane fade show active" id="pph21" role="tabpanel">
                            @include('pages.payroll.partials.pph21')
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        .head-color {
            color: #435ebe;
        }

        .summary {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .left-line-vertical {
            border-left: 1px solid #A6CDF5;
        }

        .bpjs-row {
            border-bottom: 1px solid gray;
        }
    </style>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/nocss/litepicker.js"></script>

    <script>
        const initialState = {
            //
        };

        let state = {
            ...initialState
        };

        $(document).ready(function() {
            $('.dataTable').DataTable();

            fetchInformation();
            setupSelect();
            // setupDateFilter();
        });

        function onFilter() {
            fetchInformation();
        }

        function fetchInformation() {
            $.ajax({
                url: "{{ route('api.payroll.fetchInformation') }}",
                method: 'GET',
                data: {
                    month_filter: $("#month_filter").val(),
                },
                beforeSend: function() {
                    // empty view
                },
                success: function(responses) {
                    console.info(responses);
                    const employee = responses.employee;
                    const month_readable = responses.monthReadAble;

                    $("#month_year").text(month_readable);
                    $("#employee_name").text(employee.name);
                    $("#position_name").text(employee.position_name);
                    $("#employee_number_identity").text(employee.number_identity);
                    $("#gaji_dasar").text(`Rp. ${employee.salary}`);
                    $("#tunjangan_tetap").text(`Rp. ${employee.tunjangan_tetap}`);
                    $("#rate_lembur").text(`Rp. ${employee.rate_lembur}`);
                    $("#tunjangan_makan").text(`Rp. ${employee.tunjangan_makan}`);
                    $("#tunjangan_transportasi").text(`Rp. ${employee.tunjangan_transportasi}`);
                    $("#tunjangan_kehadiran").text(`Rp. ${employee.tunjangan_kehadiran}`);
                    $("#ptkp_karyawan").text(`Rp. ${employee.ptkp_karyawan}`);
                    $("#jumlah_cuti_ijin").text(`Rp. ${employee.jumlah_cuti_ijin}`);
                    $("#sisa_cuti").text(`Rp. ${employee.sisa_cuti}`);

                },
                error: function(err) {}
            });
        }

        function onCreate() {
            clearForm();
            $("#titleForm").html("Tambah Fitur");
            onModalAction("formModal", "show");
        }

        function setupDateFilter() {
            new Litepicker({
                element: document.getElementById('month_filter'),
                format: 'YYYY-MM',
                singleMode: true,
                tooltipText: {
                    one: 'night',
                    other: 'nights'
                },
                tooltipNumber: (totalDays) => {
                    return totalDays - 1;
                },
            });
        }

        function setupSelect() {
            $(".select2").select2();
        }
    </script>
@endsection
