@extends('adminlte::page')
@section('content')
<h1>Detail Dokumen Lokasi</h1>

<div class="card">
    <div class="card-body">
        <p><strong>Nama Lokasi:</strong> {{ $dokumen->nama_lokasi }}</p>
        <p><strong>Nama File:</strong> {{ $dokumen->nama_file }}</p>
        <img src="{{ asset('storage/' . $dokumen->file_path) }}" width="300" alt="Foto">
    </div>
</div>

<a href="{{ route('dokumenlokasi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
