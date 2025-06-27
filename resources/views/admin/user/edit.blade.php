@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mb-3">Back to Users List</a>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name field -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password field (Optional) -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            <small>Leave empty if you don't want to change the password.</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password confirmation field -->
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <!-- Role field -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="Karyawan" {{ old('role', $user->role) == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                 @if(auth()->user()->role === 'Admin')
                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                 @elseif(auth()->user()->role === 'Manager')
                 <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                @endif
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- Profile Picture field -->
        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">

            <!-- Display current profile picture if it exists -->
            @if($user->profile_picture)
                <div class="mt-2">
                    <label>Current Profile Picture:</label><br>
                    <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" width="100" height="100">
                </div>
            @endif

            @error('profile_picture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <ul class="mt-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@stop
