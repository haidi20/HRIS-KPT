@php
    use Carbon\Carbon;
@endphp
<html>

<head>
    <title>Print Absensi Karyawan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        table {
            border-collapse: collapse;
            page-break-inside: auto;
            width: 100%;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        th,
        td {
            /* border: black 1px solid; */
            padding-left: 5px;
            padding-right: 5px;
            min-width: 50px;
        }

        @page {
            size: legal landscape;
            margin: 1cm;
        }

        #logo {
            width: 7rem;
            margin-bottom: 1rem;
            vertical-align: middle;
        }

        #judul {
            text-align: center;
        }

        header {
            /* position: fixed; */
            text-align: center;
            height: 10px;
            margin-bottom: 30px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .header span {
            font-size: 18px;
        }

        table span {
            font-size: 20px;
        }
    </style>
</head>

{{-- <body onload="window.print()"> --}}

<body>
    {{-- <div class="header">
        <img src="{{ asset('assets/img/logo.png') }}" id="logo" alt="">
        <span>CV. KARYA PACIFIC TEHNIK</span>
    </div> --}}

    <div style="display: flex; align-items: center; text-align: center; place-content: center;">
        <img src="{{ asset('assets/img/logo.png') }}" alt="" class="" style="width: 15%; margin-right: 50px;">
        <div>
            <span style="font-size: 32px; color: red; font-weight: bold; text-align: center;">PT. KARYA PACIFIC
                TEHNIK</span>
            <hr>
            <span>
                Jalan Raya Anggana KM.20 RT.17, Sungai Mariam, Anggana, Samarinda, Kaltim - Indonesia
                <br>
                Jalan OLAH BEBAYA RT.03, KEL. Pulau Atas, Samarinda, Kaltim - Indonesia
                <br>
                Tel. 0811-555-882
                <br>
                karyapacifictehnik@yahoo.com
                <br>
                www.karyapacifictehnik.com
            </span>
        </div>
    </div>
    <br>
    <br>

    <hr>

    <table>
        <tr style="vertical-align: top;">
            <td>
                <table>
                    <tr>
                        <td>
                            <h3>Proyek </h3>
                        </td>
                        <td>
                            <span>: {{ $data->project_name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Pekerjaan</h3>
                        </td>
                        <td>
                            <span>: {{ $data->job_name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Keterangan Pekerjaan</h3>
                        </td>
                        <td>
                            <span>: {{ $data->job_note }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Kategori</h3>
                        </td>
                        <td>
                            <span>: {{ $data->category_name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Tingkat Kesulitan</h3>
                        </td>
                        <td>
                            <span>: {{ $data->job_level_readable }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Status</h3>
                        </td>
                        <td>
                            <span>: {{ $data->status_readable }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Catatan</h3>
                        </td>
                        <td>
                            <span>: {{ $data->note }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Jam Mulai</h3>
                        </td>
                        <td>
                            <span>: {{ $data->hour_start }}</span>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <h3>Estimasi Waktu Selesai</h3>
                        </td>
                        <td>
                            <span>: {{ $data->datetime_estimation_end_readable }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Waktu Selesai</h3>
                        </td>
                        <td>
                            <span>: {{ $data->datetime_end_readable }}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <h3>Karyawan : </h3>

                <table border="1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->jobOrderHasEmployees as $index => $hasEmployee)
                            @php
                                $employee = $hasEmployee->employee;
                            @endphp
                            <tr>
                                <td>
                                    <span>
                                        {{ $employee->name }}
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        {{ $employee->position_name }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>


</body>

</html>
