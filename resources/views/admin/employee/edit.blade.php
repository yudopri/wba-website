@extends('adminlte::page')

@section('title', 'Edit Karyawan')

@section('content_header')
    <h1>Edit Karyawan</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
         @method('PUT') <!-- Menggunakan PUT untuk pembaruan -->
    @csrf

        <!-- Mengirimkan data karyawan, departemen, jabatan, dan gaji ke form -->
        @include('admin.employee.form', [
            'employee' => $employee, 
            'departemens' => $departemens, 
            'jabatans' => $jabatans, 
            'gadas' => $gadas
        ])

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop
