@extends('adminlte::page')

@section('title', 'Edit Jabatan')

@section('content_header')
    <h1>Edit Jabatan</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <!-- Form untuk mengedit GADA -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama jabatan</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $jabatan->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jabatan.index') }}" class="btn btn-secondary ml-2">Kembali</a>
            </form>
        </div>
    </div>
@stop
