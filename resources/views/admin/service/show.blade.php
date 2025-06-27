@extends('adminlte::page')

@section('title', 'Service Details')

@section('content_header')
    <h1>Service Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $service->name_service }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $service->description }}</p>

            <!-- Display the Icon if available -->
            @if($service->icon)
            <img src="{{ asset($service->icon) }}" alt="Current Icon" width="100">
            @else
                <p>No icon available</p>
            @endif
        </div>
    </div>

    <!-- Back to list button -->
    <a href="{{ route('admin.service.index') }}" class="btn btn-primary mt-3">Back to Services</a>
@stop
