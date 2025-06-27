@extends('adminlte::page')

@section('title', 'Tambah partner')

@section('content_header')
    <h1>Tambah partner</h1>
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
    <form action="{{ route('admin.partner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name_partner">Nama Perusahaan</label>
            <input type="text" name="name_partner" id="name_partner" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create Partner</button>
    </form>
@endsection
