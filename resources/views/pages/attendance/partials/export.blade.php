@php
    use Carbon\Carbon;
@endphp

<table>
    <thead>
        <tr>
            <th nowrap rowspan="2">Nama Karyawan</th>
            <th nowrap rowspan="2">Departemen</th>
            @foreach ($dates as $date)
                <th>{{ Carbon::parse($date)->format('d') }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($dates as $date)
                <th>{{ Carbon::parse($date)->locale('id')->isoFormat('dddd') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $item['employee_name'] }}</td>
                <td>{{ $item['position_name'] }}</td>
                @foreach ($dates as $date)
                    <td>
                        <div style="font-size: 12px; color: green">{{ $item[$date]->hour_start }}</div> <br>
                        <div style="font-size: 12px; color: blue">{{ $item[$date]->hour_rest_start }}</div> <br>
                        <div style="font-size: 12px; color: blue">{{ $item[$date]->hour_rest_end }}</div> <br>
                        <div style="font-size: 12px; color: green">{{ $item[$date]->hour_end }}</div>

                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
