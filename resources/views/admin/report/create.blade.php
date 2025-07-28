@extends('adminlte::page')

@section('title', 'Tambah Pengaduan Masalah')

@section('content_header')
    <h1>Form Tambah Pengaduan</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pengaduan.store') }}">
        @csrf

        <div class="mb-3">
            <label for="judul">Judul Masalah</label>
            <input type="text" class="form-control" name="judul" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi">Deskripsi Masalah</label>
            <textarea class="form-control" name="deskripsi" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="pelapor">Nama Pelapor</label>
            <input type="text" class="form-control" name="pelapor" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
