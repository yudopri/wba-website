@extends('adminlte::page')

@section('title', 'Upload Bukti Penyelesaian')

@section('content_header')
    <h1>Upload Bukti Penyelesaian</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengaduan.uploadBuktiPost', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="bukti" class="form-label">Pilih Foto Bukti:</label>
                    <input type="file" name="bukti" class="form-control" accept="image/*" required>
                    @error('bukti')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload Bukti
                </button>

                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
