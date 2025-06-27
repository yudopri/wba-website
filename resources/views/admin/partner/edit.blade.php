@extends('adminlte::page')

@section('title', 'Edit partner')

@section('content_header')
    <h1>Edit partner</h1>
@stop

@section('content')

    <!-- Display Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Service Edit Form -->
    <form action="{{ route('admin.partner.update', $partner['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Service Name -->
        <div class="form-group">
            <label for="name_partner">Nama partner</label>
            <input type="text" name="name_partner" id="name_partner" value="{{ old('name_partner', $partner['name_partner']) }}" class="form-control" required>
        </div>

        <!-- Service Icon -->
        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control-file">
</div>
            <!-- Display current icon -->
            <div class="mt-2">
    <label>Current Icon:</label>
    <img src="{{ asset($partner->icon) }}" alt="Current Icon" width="50">

</div>
        <button type="submit" class="btn btn-primary mt-3">Update Partner</button>
    </form>
@endsection
