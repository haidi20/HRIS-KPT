@php
    use Carbon\Carbon;
@endphp

<table>
    <thead>
        <tr>
            <th nowrap rowspan="2">NAMA</th>
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
                @foreach ($dates as $date)
                    <td style="background-color: {{ $item[$date]['color'] }}">{{ $item[$date]['value'] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
