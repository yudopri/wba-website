@extends('adminlte::page')

@section('title', 'Data Departemen')

@section('content_header')
    <h1>Data Departemen</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <!-- Tombol Tambah -->
    <a href="{{ route('admin.departemen.create') }}" class="btn btn-primary mb-3">Tambah Departemen</a>
    <div class="card">
    <div class="card-body">
    <!-- Tabel Departemen -->
    <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                <th class="text-nowrap">No</th>
                <th class="text-nowrap">Nama Departemen</th>
                <th class="text-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departemens as $index => $departemen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $departemen->name }}</td>
                    <td>
                        <a href="{{ route('admin.departemen.edit', $departemen->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.departemen.destroy', $departemen->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   @elseif(auth()->user()->role === 'Karyawan')
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif
</div>
</div>
@stop
