@extends('adminlte::page')

@section('title', 'View Article')

@section('content_header')
    <h1>View Article</h1>
@stop

@section('content')
    <!-- Tombol Kembali -->
    <a href="{{ route('admin.article.index') }}" class="btn btn-secondary mb-3">Back to Articles</a>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $article->title }}</h3>
        </div>
        <div class="card-body">
            <!-- Gambar Artikel -->
            @if($article->image)
                <div class="mb-3 text-center">
                    <img src="{{ asset($article->image) }}" alt="Article Image" class="img-fluid" style="max-width: 400px;">
                </div>
            @else
                <div class="mb-3 text-center">
                    <img src="{{ asset('images/default-image.jpg') }}" alt="Default Image" class="img-fluid" style="max-width: 400px;">
                </div>
            @endif

            <!-- Deskripsi Artikel -->
            <div class="mb-3">
                <strong>Description:</strong>
                <p>{{ $article->description }}</p>
            </div>

            <!-- Tanggal Artikel -->
            <div class="mb-3">
                <strong>Date:</strong>
                <p>{{ $article->date }}</p>
            </div>
        </div>
        <div class="card-footer">
            <!-- Tombol Edit dan Hapus -->
            <a href="{{ route('admin.article.edit', $article->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.article.destroy', $article->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
            </form>
        </div>
    </div>
@stop
