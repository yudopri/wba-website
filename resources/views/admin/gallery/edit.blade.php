@extends('adminlte::page')

@section('title', 'Edit Gallery Item')

@section('content_header')
    <h1>Edit Gallery Item</h1>
@stop

@section('content')
    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" placeholder="Enter title">
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

        @if($gallery->image_url)
            <div class="form-group mt-2">
                <img src="{{ asset($gallery->image_url) }}" alt="Gallery Image" width="150">
            </div>
        @endif

        <button type="submit" class="btn btn-warning mt-3">Update Gallery Item</button>
    </form>
@stop
