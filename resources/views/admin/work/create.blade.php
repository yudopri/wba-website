@extends('adminlte::page')

@section('title', 'Tambah Lokasi Kerja')

@section('content_header')
    <h1>Tambah Lokasi Kerja</h1>
@stop

@section('content')
    <form action="{{ route('admin.work.store') }}" method="POST" enctype="multipart/form-data"  >
        @csrf
        <div class="form-group">
            <label for="name">Nama Perusahaan</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama perusahaan" required>
        </div>

 <div class="form-group">
            <label for="berlaku">Masa Berlaku Kontrak</label>
            <input type="date" name="berlaku" id="berlaku" class="form-control">
        </div>
        <div class="form-group">
    <label>Foto Dokumen Kontrak</label>
    <div class="row align-items-center">
         <div class="col-md-3">
        <input type="file" name="pict_dokumen" id="pict_dokumen" class="form-control">
            </div>
             <div class="col-md-3">
        <input type="file" name="pict_dokumen1" id="pict_dokumen1" class="form-control">
            </div>
             <div class="col-md-3">
        <input type="file" name="pict_dokumen2" id="pict_dokumen2" class="form-control">
            </div>
    </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@stop
