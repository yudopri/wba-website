@extends('adminlte::page')

@section('title', 'Edit Lokasi Kerja')

@section('content_header')
    <h1>Edit Lokasi Kerja</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <!-- Form untuk mengedit GADA -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.work.update', $work->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Lokasi Kerja</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $work->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

 <div class="form-group">
            <label for="berlaku">Masa Berlaku Kontrak</label>
            <input type="date" name="berlaku" id="berlaku" class="form-control" value="{{ old('berlaku', isset($work) ? $work->berlaku : '') }}" {{ auth()->user()->role === 'Karyawan' && isset($work) && $work->berlaku ? 'readonly' : '' }} >
        </div>

         <div class="form-group">
    <label>Foto Dokumen Kontrak</label>
    <div class="row align-items-center">
         <div class="col-md-3">
        <input type="file" name="pict_dokumen" id="pict_dokumen" class="form-control">
        @if(isset($work) && $work->pict_dokumen)
            <p><a href="{{ asset($work->pict_dokumen) }}" target="_blank">Lihat Foto Dokumen Kontrak</a></p>
        @elseif(!isset($work))
            <p>Upload Foto Dokumen Kontrak jika ada.</p>
        @else
            <p>Tidak ada foto Dokumen Kontrak.</p>
        @endif
            </div>
             <div class="col-md-3">
        <input type="file" name="pict_dokumen1" id="pict_dokumen1" class="form-control">
        @if(isset($work) && $work->pict_dokumen1)
            <p><a href="{{ asset($work->pict_dokumen1) }}" target="_blank">Lihat Foto Dokumen Kontrak</a></p>
        @elseif(!isset($work))
            <p>Upload Foto Dokumen Kontrak jika ada.</p>
        @else
            <p>Tidak ada foto Dokumen Kontrak.</p>
        @endif
            </div>
             <div class="col-md-3">
        <input type="file" name="pict_dokumen2" id="pict_dokumen2" class="form-control">
        @if(isset($work) && $work->pict_dokumen2)
            <p><a href="{{ asset($work->pict_dokumen2) }}" target="_blank">Lihat Foto Dokumen Kontrak</a></p>
        @elseif(!isset($work))
            <p>Upload Foto Dokumen Kontrak jika ada.</p>
        @else
            <p>Tidak ada foto Dokumen Kontrak.</p>
        @endif
            </div>
    </div>
        </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.work.index') }}" class="btn btn-secondary ml-2">Kembali</a>
            </form>
        </div>
    </div>
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
