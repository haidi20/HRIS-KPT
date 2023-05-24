<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
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
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $item['creator_name'] }}</td>
                    <td>{{ $item['employee_name'] }}</td>
                    <td>{{ $item['position_name'] }}</td>
                    <td>{{ $item['date_start_readable'] }}</td>
                    <td>{{ $item['date_end_readable'] }}</td>
                    <td>{{ $item['duration_readable'] }}</td>
                    <td>{{ $item['note'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
