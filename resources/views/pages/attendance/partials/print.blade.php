@php
    use Carbon\Carbon;
@endphp
<html>

<head>
    <title>sdfsfsdf</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        table {
            border-collapse: collapse;
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        thead {
            display: table-header-group
        }

        th,
        td {
            border: black 1px solid;
            padding-left: 5px;
            padding-right: 5px;
            /* min-width: 200px; */
        }

        @page {
            size: legal landscape;
            margin: 1cm;

        }

        #logo {
            width: 7rem;
            margin-bottom: 1rem;
            vertical-align: -webkit-baseline-middle;
        }
    </style>
</head>

<body onload="window.print()">

    {{-- <body> --}}
    <div>
        <img src="{{ asset('assets/img/logo.png') }}" id="logo" alt="">
        <span>
            CV. KARYA PACIFIC TEHNIK
        </span>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th nowrap>Hari</th>
                <th nowrap>Jam Masuk</th>
                <th nowrap>Jam Pulang</th>
                <th nowrap>Durasi</th>
                <th nowrap>Jam Istirahat</th>
                <th nowrap>Jam Selesai Istirahat</th>
                <th nowrap>Durasi Jam Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td nowrap>{{ $item->day }}</td>
                    <td nowrap>{{ $item->hour_start }}</td>
                    <td nowrap>{{ $item->hour_end }}</td>
                    <td nowrap>{{ $item->duration }}</td>
                    <td nowrap>{{ $item->hour_rest_start }}</td>
                    <td nowrap>{{ $item->hour_rest_end }}</td>
                    <td nowrap>{{ $item->duration_hour_work }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
