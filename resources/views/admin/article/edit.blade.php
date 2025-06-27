@extends('adminlte::page')

@section('title', 'Edit Article')

@section('content_header')
    <h1>Edit Article</h1>
@stop
@section('content')
<div class="container">
    <h1 class="mt-4">Edit Article</h1>
    <form action="{{ route('admin.article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $article->title) }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4" required>{{ old('description', $article->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" id="image">
            @if ($article->image)
                <img src="{{ asset($article->image) }}" alt="Article Image" class="mt-2" width="100">
            @endif
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" id="date" value="{{ old('date', $article->date) }}">
            @error('date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
