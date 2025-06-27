@extends('adminlte::page')

@section('title', 'Tambah Lokasi Kerja')

@section('content_header')
    <h1>Tambah Lokasi Kerja</h1>
@stop

@section('content')
    <form action="{{ route('admin.work.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Perusahaan</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama perusahaan" required>
        </div>
        
 <div class="form-group">
            <label for="berlaku">Masa Berlaku Kontrak</label>
            <input type="date" name="berlaku" id="berlaku" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@stop
