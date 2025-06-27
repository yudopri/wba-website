@extends('adminlte::page')

@section('title', 'Data service')

@section('content_header')
    <h1>Data service</h1>
@stop

@section('content')
@if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <a href="{{ route('admin.service.create') }}" class="btn btn-primary mb-3">Add New Jasa</a>

    @if(session('message'))
        <p class="alert alert-info">{{ session('message') }}</p>
    @endif
    <div class="card">
    <div class="card-body">
    <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                <th class="text-nowrap">Nama Jasa</th>
                <th class="text-nowrap">Deskripsi</th>
                <th class="text-nowrap">Icon</th>
                <th class="text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->name_service }}</td>
                    <td>{{ $service->description }}</td>
                    <td>
                        @if($service->icon)
                        <img src="{{ asset($service->icon) }}" alt="Current Icon" width="100">
                        @else
                            <img src="{{ asset('images/default-icon.jpg') }}" alt="Default Icon" width="100">
                        @endif
                    </td>
                    <td>
                        <!-- View Service -->
                        <a href="{{ route('admin.service.show', $service->id) }}" class="btn btn-info btn-sm">View</a>

                        <!-- Edit Service -->
                        <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete Service -->
                        <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
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
