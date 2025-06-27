@extends('adminlte::page')

@section('title', 'Tambah Departemen')

@section('content_header')
    <h1>Tambah Departemen</h1>
@stop

@section('content')
    <form action="{{ route('admin.departemen.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Departemen</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama departemen" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@stop
