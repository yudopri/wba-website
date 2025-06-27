{{-- resources/views/admin/user/show.blade.php --}}

@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Details of User: {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <!-- Display user details -->
            <div class="form-group">
                <label>Name:</label>
                <p>{{ $user->name }}</p>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <p>{{ $user->email }}</p>
            </div>

            <!-- <div class="form-group">
                <label>Verification Status:</label>
                <p>{{ $user->verifikasi ? 'Verified' : 'Not Verified' }}</p>
            </div> -->


            <!-- Back to users list -->
            <div class="form-group">
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>
        </div>
    </div>
@stop
