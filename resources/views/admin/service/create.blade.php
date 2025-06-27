@extends('adminlte::page')

@section('title', 'Tambah Jasa')

@section('content_header')
    <h1>Tambah Jasa</h1>
@stop

@section('content')

    <!-- Display Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Service Creation Form -->
    <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nama_jasa">Nama Jasa</label>
            <input type="text" name="name_service" id="name_service" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Jasa</button>
    </form>
@endsection
