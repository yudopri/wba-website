@extends('adminlte::page')
@section('content')
<h1>Upload Foto Lokasi</h1>

<form action="{{ route('dokumenlokasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Nama File</label>
        <input type="text" name="nama_file" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Unggah Foto</label>
        <input type="file" name="foto" class="form-control-file" accept="image/*" required>
    </div>
    <button class="btn btn-success">Upload</button>
</form>
@endsection
