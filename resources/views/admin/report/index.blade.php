@extends('adminlte::page')
@section('content')
<h1>Data Seluruh Pengaduan</h1>
<a href="/pengaduan/form" class="btn btn-primary">Buat Pengaduan</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Pelapor</th>
        <th>Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Kehilangan</td>
        <td>hilang</td>
        <td>Terkirim</td>
        <td>Fajar</td>
        <td><a href="{{ route('laporanmasalah.detail') }}" class="btn btn-info">Detail</a>
            <a href="/pengaduan/validasi" class="btn btn-warning">Validasi Pengaduan</a>
        <a href="/pengaduan/approve" class="btn btn-success">Approval Pengaduan</a></td>
    </tr>
</table>
@endsection
