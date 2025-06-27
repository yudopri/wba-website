@extends('adminlte::page')

@section('title', 'Tambah Sertifikasi')

@section('content_header')
    <h1>Tambah Sertifikasi</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <!-- Form untuk menambah GADA -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gada.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Sertifikasi</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.gada.index') }}" class="btn btn-secondary ml-2">Kembali</a>
            </form>
        </div>
    </div>
@stop
