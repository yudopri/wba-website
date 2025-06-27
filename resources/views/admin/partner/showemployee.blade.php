@extends('adminlte::page')

@section('title', 'Daftar Karyawan')

@section('content_header')
    <h1>Daftar Karyawan</h1>
@stop

@section('content')
    @if(auth()->user()->role === 'head')

        @if(session('message'))
            <p class="alert alert-info">{{ session('message') }}</p>
        @endif

        <div class="mb-3">
            <!-- Back Button -->
            <a href="{{ route('admin.partner.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th class="text-nowrap">Nama Karyawan</th>
                            <th class="text-nowrap">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->jabatan->name ?? 'Jabatan Tidak Tersedia' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(auth()->user()->role === 'karyawan')
        <h3>Hanya untuk Kepala</h3>
    @endif
@endsection
