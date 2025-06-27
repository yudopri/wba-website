@extends('adminlte::page')

@section('title', 'Add Gallery Item')

@section('content_header')
    <h1>Add New Gallery Item</h1>
@stop

@section('content')
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter title">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_url">Image</label>
            <input type="file" name="image_url" class="form-control">
            @error('image_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Add Gallery Item</button>
    </form>
@stop
