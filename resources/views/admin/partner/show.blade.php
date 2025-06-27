@extends('adminlte::page')

@section('title', 'partner Details')

@section('content_header')
    <h1>partner Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $partner->name_partner }}</h3>
        </div>
        <div class="card-body">
            <!-- Display the Icon if available -->
            @if($partner->icon)
            <img src="{{ asset($partner->icon) }}" alt="Current Icon" width="100">
            @else
                <p>No icon available</p>
            @endif
        </div>
    </div>

    <!-- Back to list button -->
    <a href="{{ route('admin.partner.index') }}" class="btn btn-primary mt-3">Back to Partners</a>
@stop
