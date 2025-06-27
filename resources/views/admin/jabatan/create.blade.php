@extends('adminlte::page')

@section('title', 'Tambah Jabatan')

@section('content_header')
    <h1>Tambah Jabatan</h1>
@stop

@section('content')
    <form action="{{ route('admin.jabatan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Jabatan</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama jabatan" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@stop
