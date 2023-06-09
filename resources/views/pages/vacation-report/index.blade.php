@extends('layouts.master')

@section('content')
    @include('pages.salary-advance-report.partials.modal')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Cuti</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="#">Pengaturan</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Cuti</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicInput">Pilih Tanggal</label>
                                <input type="text" class="form-control" id="month" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4" style="align-self: center">
                            <button type="button" onclick="onFilter()" class="btn btn-sm btn-success">Kirim</button>
                            @can('ekspor laporan cuti')
                                <button type="button" id="btn_export" onclick="onExport()"
                                    class="btn btn-sm btn-success mt-2 ml-4 mt-md-0">
                                    <i class="fas fa-file-excel"></i> Export
                                </button>
                                <div id="place_loading_export"></div>
                            @endcan
                        </div>
                    </div>
                    <br>
                    <div id="place_table"></div>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        #place_loading_export {
            align-self: self-end;
            margin-left: 10px;
            display: inline;
        }
    </style>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/nocss/litepicker.js"></script>

    <script>
        const initialState = {
            date_start: null,
            date_end: null,
            vacations: [],
        };

        let state = {
            ...initialState
        };

        $(document).ready(function() {
            state.date_start = "{{ $dateStart }}";
            state.date_end = "{{ $dateEnd }}";


            fetchData();
            setupDateFilter();
        });

        function setupDateFilter() {
            new Litepicker({
                element: document.getElementById('month'),
                singleMode: false,
                tooltipText: {
                    one: 'night',
                    other: 'nights'
                },
                tooltipNumber: (totalDays) => {
                    return totalDays - 1;
                },
                setup: (picker) => {
                    picker.on('selected', (startDate, endDate) => {
                        startDate = moment(startDate.dateInstance).format("YYYY-MM-DD");
                        endDate = moment(endDate.dateInstance).format("YYYY-MM-DD");

                        state.date_start = startDate;
                        state.date_end = endDate;
                    });
                },
            });
        }

        function onFilter() {
            fetchData();
        }

        function onExport() {
            // console.info("export");
            $("#btn_export").prop("disabled", true);
            $("#place_loading_export").append("Loading...");
            $.ajax({
                url: "{{ route('report.vacation.export') }}",
                method: 'GET',
                data: {
                    date_start: state.date_start,
                    date_end: state.date_end,
                },
                beforeSend: function() {

                },
                success: function(responses) {
                    $("#btn_export").prop("disabled", false);
                    $("#place_loading_export").empty();
                    const path = responses.path;
                    // console.info(responses);
                    if (responses.success) {
                        window.open(
                            `${responses.linkDownload}`,
                            '_blank');
                    }

                },
                error: function(err) {
                    $("#btn_export").prop("disabled", false);
                    $("#place_loading_export").empty();

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 10000,
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


        function fetchData() {
            $.ajax({
                url: "{{ route('api.report.vacation.fetchData') }}",
                method: 'GET',
                data: {
                    date_start: state.date_start,
                    date_end: state.date_end,
                },
                beforeSend: function() {
                    // empty view
                    $("#place_table").empty();
                    $("#place_table").append(
                        viewTable()
                    );
                    setEmptyOrProcessTbody("loading...");
                },
                success: function(responses) {
                    console.info(responses);
                    let rows = "";
                    const vacations = responses.vacations;

                    if (vacations.length > 0) {
                        $("#tbody").empty();
                        vacations.map(vacation => {
                            rows += `
                            <tr>
                                <td>${vacation.creator_name}</td>
                                <td>${vacation.employee_name}</td>
                                <td>${vacation.position_name}</td>
                                <td>${vacation.date_start_readable}</td>
                                <td>${vacation.date_end_readable}</td>
                                <td>${vacation.duration_readable}</td>
                                <td>${vacation.note}</td>
                            </tr>
                        `;
                        });

                        $("#tbody").append(rows);
                        $('.dataTable').DataTable();
                    } else {
                        setEmptyOrProcessTbody("tidak ada data");
                    }

                },
                error: function(err) {}
            });
        }

        function setEmptyOrProcessTbody(message) {
            let rows = "";

            rows += `
                <tr>
                    <td colspan="20">${message}</td>
                </tr>
            `;

            $("#tbody").empty();
            $("#tbody").append(rows);
        }

        function viewTable() {
            return `
                <table class="table table-striped dataTable" id="table1">
                    <thead>
                        <tr>
                            <th>Di Buat Oleh</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jangka Waktu</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
            `;
        }

        function clearForm() {
            $("#id").val("");
            $("#name").val("");
            $("#description").val("");
        }
    </script>
@endsection
