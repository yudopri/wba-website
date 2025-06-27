@extends('adminlte::page')

@section('title', 'Gallery')

@section('content_header')
    <h1>Gallery</h1>
@stop

@section('content')
@if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary mb-3">Add New Gallery Item</a>

    @if(session('success'))
        <p class="alert alert-info">{{ session('success') }}</p>
    @endif
    <div class="card">
    <div class="card-body">
    <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                <th class="text-nowrap">Title</th>
                <th class="text-nowrap">Image</th>
                <th class="text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($galleries as $gallery)
                <tr>
                    <td>{{ $gallery->title }}</td>
                    <td>
                        @if($gallery->image_url)
                            <img src="{{ asset($gallery->image_url) }}" alt="Gallery Image" width="100">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" alt="Default Image" width="100">
                        @endif
                    </td>
                    <td>
                        <!-- Edit -->
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete -->
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this gallery item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
 @elseif(auth()->user()->role === 'Karyawan')
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif
@endsection
