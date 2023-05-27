<div style="display: flex;">
        {{-- <img src="{{ public_path('/assets/img/logo.png') }}" alt="" class="" style="width: 10%;"> --}}
        PT KARYA PACIFIC SHIPYARD
</div>
<table width="100%">
    <thead>
        <tr>No.</tr>
        <tr>Nama Karyawan</tr>
        <tr>Departemen</tr>
    </thead>
    @foreach ($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
    </tr>
    @endforeach
</table>
