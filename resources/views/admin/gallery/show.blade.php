@extends('adminlte::page')

@section('title', 'Gallery Detail')

@section('content_header')
    <h1>Gallery Detail</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $gallery->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $gallery->image_url) }}" class="img-fluid" alt="Gallery Image">
                </div>
                <div class="col-md-6">
                    <p><strong>Title:</strong> {{ $gallery->title }}</p>
                    <p><strong>Image URL:</strong> {{ $gallery->image_url }}</p>
                    <p><strong>Created At:</strong> {{ $gallery->created_at }}</p>
                    <p><strong>Updated At:</strong> {{ $gallery->updated_at }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Back to Gallery</a>
            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this gallery item?')">Delete</button>
            </form>
        </div>
    </div>
@stop
