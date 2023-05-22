<table>
    <thead>
        <tr>
            <th nowrap>Nama Proyek</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $item['name'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
