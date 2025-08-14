@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create New User</h1>
@stop

@section('content')
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mb-3">Back to Users List</a>

    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


         <!-- Email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password field -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role field -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="Karyawan" {{ old('role') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                 @if(auth()->user()->role === 'Admin')
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                 @elseif(auth()->user()->role === 'Manager')
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Keuangan" {{ old('role') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                <option value="Lapangan" {{ old('role') == 'Lapangan' ? 'selected' : '' }}>Lapangan</option>
                <option value="Logistik" {{ old('role') == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                @endif
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
@stop
