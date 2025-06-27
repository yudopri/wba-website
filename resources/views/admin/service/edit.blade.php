@extends('adminlte::page')

@section('title', 'Edit Jasa')

@section('content_header')
    <h1>Edit Jasa</h1>
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

    <!-- Service Edit Form -->
    <form action="{{ route('admin.service.update', $service['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Service Name -->
        <div class="form-group">
            <label for="name_service">Nama Jasa</label>
            <input type="text" name="name_service" id="name_service" value="{{ old('name_service', $service['name_service']) }}" class="form-control" required>
        </div>

        <!-- Service Description -->
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $service['description']) }}</textarea>
        </div>

        <!-- Service Icon -->
        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control-file">

            <!-- Display current icon -->
            <div class="mt-2">
    <label>Current Icon:</label>
    <img src="{{ asset($service->icon) }}" alt="Current Icon" width="50">

</div>


        <button type="submit" class="btn btn-primary mt-3">Update Jasa</button>
    </form>
@endsection
